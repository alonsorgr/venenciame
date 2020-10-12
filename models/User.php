<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;
use yii\web\UploadedFile;
use app\helpers\AmazonS3;

/**
 * Esta es la clase modelo para la tabla "users".
 * 
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 * 
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string|null $auth_key
 * @property string|null $verf_key
 * @property int|null $status_id
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
 * @property Followers[] $followers
 * @property Partners[] $partners
 * @property Partners $partners0
 * @property Languages $language
 * @property Statuses $status
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * Constantes de estado del usuario.
     */
    const STATUS_DELETED = 1;
    const STATUS_INACTIVE = 2;
    const STATUS_ACTIVE = 3;

    /**
     * Constantes de escenarios
     */
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * Constante de imagen de perfil de usuario.
     */
    const IMAGE = '@web/img/user.jpg';

    /**
     * Variable de subida de imagen de perfil de usuario.
     *
     * @var string
     */
    public $upload;

    /**
     * Atributo virtual para enlace a imagen de perfil.
     *
     * @var string
     */
    private $_link = null;

    /**
     * Areibuto virtual para concatenación de nombre completo.
     *
     * @var string
     */
    private $_fullname = null;

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
            [['username', 'email'], 'required'],
            [
                ['username', 'email'], 'unique',
                'on' => [self::SCENARIO_CREATE],
            ],
            [
                ['username', 'email'], 'unique',
                'skipOnError' => true,
                'on' => [self::SCENARIO_UPDATE],
            ],
            [
                ['password', 'rol_id', 'language_id'],
                'required',
                'on' => [
                    self::SCENARIO_CREATE
                ]
            ],
            [['status_id', 'rol_id', 'language_id'], 'default', 'value' => null],
            [['status_id', 'rol_id', 'language_id'], 'integer'],
            [['admin', 'privacity'], 'boolean'],
            [['birthdate', 'updated_at', 'created_at'], 'safe'],
            [['username', 'auth_key', 'verf_key', 'name', 'surname'], 'string', 'max' => 32],
            [['password', 'email'], 'string', 'max' => 64],
            [['image'], 'file'],
            [['image'], 'safe'],
            [['image'], 'string', 'max' => 255],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Languages::class, 'targetAttribute' => ['language_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Statuses::className(), 'targetAttribute' => ['status_id' => 'id']],
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
            'status_id' => Yii::t('app', 'Estado'),
            'admin' => Yii::t('app', 'Administrador del sitio'),
            'privacity' => Yii::t('app', 'Privacidad'),
            'name' => Yii::t('app', 'Nombre'),
            'surname' => Yii::t('app', 'Apellido'),
            'birthdate' => Yii::t('app', 'Fecha de nacimiento'),
            'image' => Yii::t('app', 'Subir imagen de perfil'),
            'upload' => Yii::t('app', 'Subir imagen de perfil'),
            'rol_id' => Yii::t('app', 'Rol de usuario'),
            'language_id' => Yii::t('app', 'Idioma preferido'),
            'updated_at' => Yii::t('app', 'Actualizado'),
            'created_at' => Yii::t('app', 'Creado'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->uploadImage();

        if ($insert) {
            if ($this->scenario === self::SCENARIO_CREATE) {
                $this->generatePasswordHash($this->password);
            }
        } else {
            if ($this->scenario === self::SCENARIO_UPDATE) {
                if ($this->password === '') {
                    $this->password = $this->getOldAttribute('password');
                } else {
                    $this->generatePasswordHash($this->password);
                }
            }
        }
        return true;
    }

    /**
     * Sube la imagen de perfil del usuario a Amazon Web Services S3.
     *
     * @return void
     */
    public function uploadImage()
    {
        $this->upload = UploadedFile::getInstance($this, 'upload');
        if ($this->upload !== null) {
            $this->image = AmazonS3::upload($this->upload, $this->username, AmazonS3::BUCKET_USERS, $this->image);
            $this->upload = null;
        }
    }

    /**
     * Genera un enlace a la imagen de perfil del usuario actual.
     *
     * @param   string    $link   enlace a imagen de perfil.
     * @return  void
     */
    public function setLink($link)
    {
        $this->_link = $link;
    }

    /**
     * Genera un enlace a la imagen de perfil del usuario actual.
     *
     * @return  string  enlace a imagen de perfil.
     */
    public function getLink()
    {
        if ($this->_link === null && !$this->isNewRecord) {
            $this->setLink(AmazonS3::getLink($this->image, self::IMAGE, AmazonS3::USER, AmazonS3::BUCKET_USERS));
        }
        return $this->_link;
    }

    public function setFullname($fullname)
    {
        $this->_fullname = $fullname;
    }

    public function getFullname()
    {
        if ($this->_fullname === null && !$this->isNewRecord) {
            $this->setFullname($this->name . ' ' . $this->surname);
        }
        return $this->_fullname;
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
        return $this->status_id === self::STATUS_ACTIVE;
    }

    /**
     * Establece el stado del usuario como activo.
     *
     * @return void
     */
    public function setActive()
    {
        $this->status_id = self::STATUS_ACTIVE;
    }

    /**
     * Establece el stado del usuario como no activo.
     *
     * @return void
     */
    public function setInactive()
    {
        $this->status_id = self::STATUS_INACTIVE;
    }

    /**
     * Establece el stado del usuario como eliminado.
     *
     * @return void
     */
    public function setDeleted()
    {
        $this->status_id = self::STATUS_DELETED;
    }

    /**
     * Establece el escenario create en el modelo [[User]]
     *
     * @return void
     */
    public function setScenarioCreate()
    {
        $this->scenario = self::SCENARIO_CREATE;
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
     * Obtiene consulta para [[Followers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFollowers()
    {
        return $this->hasMany(Followers::class, ['user_id' => 'id'])->inverseOf('user');
    }

    /**
     * Obtiene consulta para [[Partners]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPartners0()
    {
        return $this->hasOne(Partners::class, ['user_id' => 'id']);
    }

    /**
     * Obtiene consulta para [[Languages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Languages::class, ['id' => 'language_id'])->inverseOf('users');
    }

    /**
     * Obtiene consulta para [[Partners]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPartners()
    {
        return $this->hasOne(Partners::class, ['user_id' => 'id'])->inverseOf('user');
    }

    /**
     * Obtiene consulta para [[Statuses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Statuses::class, ['id' => 'status_id'])->inverseOf('users');
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

    /**
     * Función estática para obtener el id de socio del usuario.
     *
     * @return int | string     el id de socio del usuario actual | cadena vacía si no hay id del usuario actual.
     */
    public static function partnerId()
    {
        return !Yii::$app->user->isGuest ? Yii::$app->user->identity->partners->id : '';
    }

    /**
     * Comprueba si el usuario es administrador.
     *
     * @return boolean  verdadero si el usuario es administrador.
     */
    public static function isAdmin()
    {
        return !Yii::$app->user->isGuest ? Yii::$app->user->identity->admin : false;
    }

    /**
     * Comprueba si el usuario es socio.
     *
     * @return boolean  verdadero si el usuario es socio.
     */
    public static function isPartner()
    {
        return Partners::findOne(['user_id' => static::id()]) != null ?: false;
    }

    /**
     * Comprueba si el acceso del usuario es válido para determinada acción.
     *
     * @return boolean  verdadero si es coinciden los id's.
     */
    public static function isOwner()
    {
        return intval(Yii::$app->getRequest()->getQueryParam('id')) === static::id();
    }

    /**
     * Comprueba si el usuario está activo.
     *
     * @return boolean  verdadero si el usuario está activo.
     */
    public static function active()
    {
        return static::find()->where(['id' => intval(Yii::$app->getRequest()->getQueryParam('id'))])->one()->status_id === 3;
    }

    /**
     * Genera una lista con las etiquetas de los objetos [[User]]
     *
     * @return array    array con las etiquetas de [[User]] indexados por id.
     */
    public static function labels()
    {
        return static::find()->select('username')->orderBy('id')->indexBy('id')->column();
    }
}
