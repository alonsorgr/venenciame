<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string|null $auth_key
 * @property string|null $verf_key
 * @property int|null $status
 * @property bool|null $admin
 * @property bool|null $privacity
 * @property string|null $name
 * @property string|null $surname
 * @property string|null $birthdate
 * @property string|null $image
 * @property int|null $rol_id
 * @property int|null $language_id
 * @property string|null $updated_at
 * @property string|null $created_at
 *
 * @property Addresses[] $addresses
 * @property Languages $language
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * Constantes de estado del usuario.
     */
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    /**
     * Constantes de escenarios
     */
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'up';

    /**
     * Constante de imagen de perfil de usuario.
     */
    const IMAGE = '@img/users/user.jpg';

    /**
     * Variable de subida de imagen de operfil de usuario.
     *
     * @var string
     */
    public $upload;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => User::STATUS_INACTIVE],
            ['status', 'in', 'range' => [User::STATUS_ACTIVE, User::STATUS_INACTIVE, User::STATUS_DELETED]],
            [
                ['username', 'password', 'email'], 'required',
                'on' => [
                    self::SCENARIO_CREATE
                ],
            ],
            [['rol_id', 'language_id'], 'default', 'value' => null],
            [['rol_id', 'language_id'], 'integer'],
            [['admin', 'privacity'], 'boolean'],
            [['birthdate', 'updated_at', 'created_at'], 'safe'],
            [['username', 'auth_key', 'verf_key', 'name', 'surname'], 'string', 'max' => 32],
            [['password', 'email'], 'string', 'max' => 64],
            [
                ['username', 'email'], 'unique',
                'on' => [
                    self::SCENARIO_CREATE
                ],
            ],
            //[['image'], 'file'],
            [['image'], 'safe'],
            [['image'], 'string', 'max' => 255],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Languages::class, 'targetAttribute' => ['language_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Nombre de usuario'),
            'password' => Yii::t('app', 'Contraseña'),
            'email' => Yii::t('app', 'Correo electrónico'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'verf_key' => Yii::t('app', 'Verf Key'),
            'status' => Yii::t('app', 'Status'),
            'admin' => Yii::t('app', 'Admin'),
            'privacity' => Yii::t('app', 'Privacidad'),
            'name' => Yii::t('app', 'Nombre'),
            'surname' => Yii::t('app', 'Primer apellido'),
            'birthdate' => Yii::t('app', 'Fecha de nacimiento'),
            'image' => Yii::t('app', 'Imagen de usuario'),
            'rol_id' => Yii::t('app', 'Rol de usuario'),
            'language_id' => Yii::t('app', 'Idioma preferido'),
            'updated_at' => Yii::t('app', 'Actualizado'),
            'created_at' => Yii::t('app', 'Creado'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException(Yii::t('app', 'Función findIdentityByAccessToken no implementada.'));
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Genera una clave de validación.
     *
     * @return void
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Elimina la clave de validación.
     *
     * @return void
     */
    public function removeAuthKey()
    {
        $this->auth_key = null;
    }

    /**
     * Búsqueda de usuario por id de usuario.
     *
     * @param   string      $username  Id de usuario.
     * @return  static|null
     */
    public static function findById($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * Búsqueda de usuario por nombre de usuario.
     *
     * @param   string      $username  Nombre de usuario.
     * @return  static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Búsqueda de usuario por dirección de correo electrónico.
     *
     * @param   string      $email  Dirección de correo electrónico.
     * @return  static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * Valida la contraseña del usuario.
     *
     * @param   string $password    contraseña a validar con la del usuario.
     * @return  bool                verdadero si el hash de las contraseñas coinciden.
     */
    public function validatePasswordHash($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Genera un hash para la contraseña de usuario.
     *
     * @param string $password  contraseña a generar el hash de la contraseña de usuario.
     * @return void
     */
    public function generatePasswordHash($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Genera una clave para el cambio de contraseña.
     *
     * @return void
     */
    public function generatePasswordVerfKey()
    {
        $this->verf_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Elimina la clave de cambio de contraseña
     *
     * @return void
     */
    public function removePasswordVerfKey()
    {
        $this->verf_key = null;
    }

    public function validatePasswordVerfKey($verf_key)
    {
        return $this->verf_key === $verf_key;
    }

    /**
     * Determina si el usuario tiene la cuenta activa.
     *
     * @return boolean  verdadero si el usuario tiene la cuenta activa.
     */
    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Establece el stado del usuario como activo.
     *
     * @return void
     */
    public function setActive()
    {
        $this->status = self::STATUS_ACTIVE;
    }

    /**
     * Establece el stado del usuario como no activo.
     *
     * @return void
     */
    public function setInactive()
    {
        $this->status = self::STATUS_INACTIVE;
    }

    /**
     * Establece el escenario update en el modelo [[User]]
     *
     * @return void
     */
    public function setScenarioUpdate()
    {
        $this->scenario = self::SCENARIO_UPDATE;
    }

    /**
     * Establece el stado del usuario como eliminado.
     *
     * @return void
     */
    public function setDeleted()
    {
        $this->status = self::STATUS_DELETED;
    }

    /**
     * Relación de usuarios con [[Addresses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Addresses::class, ['user_id' => 'id'])->inverseOf('user');
    }

    /**
     * Relación de usuarios con [[Language]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Languages::class, ['id' => 'language_id'])->inverseOf('users');
    }

    /**
     * Función estática para obtener el id del usuario.
     *
     * @return int | string     el id del usuario actual | cadena vacía si no hay usuario actual.
     */
    public static function id()
    {
        return !Yii::$app->user->isGuest ? Yii::$app->user->identity->id : '';
    }
}
