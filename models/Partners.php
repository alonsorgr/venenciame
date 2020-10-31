<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use app\helpers\AmazonS3;
use borales\extensions\phoneInput\PhoneInputValidator;

/**
 * Esta es la clase modelo para la tabla "socios"..
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $description
 * @property string|null $information
 * @property string|null $image
 * @property int $country_id
 * @property int $state_id
 * @property string $city
 * @property string $zip_code
 * @property string $address
 * @property string $phone
 * @property string|null $url
 * @property string|null $email
 * @property string|null $updated_at
 * @property string $created_at
 * @property Followers[] $followers
 * @property Users[] $users
 * @property Countries $country
 * @property States $state
 * @property Status $status
 * @property Users $user
 */
class Partners extends \yii\db\ActiveRecord
{
    /**
     * Constante de imagen de logo corporativo.
     */
    const IMAGE = '@web/img/partners.jpg';

    /**
     * Variable de subida de imagen de logo corporativo.
     *
     * @var string
     */
    public $upload;

    /**
     * Atributo virtual para enlace a logo corporativo.
     *
     * @var string
     */
    private $_link = null;

    /**
     * Atributo virtual para mostrar dirección completa.
     *
     * @var string
     */
    private $_location = null;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'partners';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'status_id', 'country_id', 'state_id', 'city', 'zip_code', 'address', 'phone'], 'required'],
            [['user_id', 'country_id', 'state_id'], 'default', 'value' => null],
            [['user_id', 'country_id', 'state_id'], 'integer'],
            [['information'], 'string'],
            [['updated_at', 'created_at'], 'safe'],
            [['name'], 'string', 'max' => 32],
            [['description', 'image'], 'string', 'max' => 255],
            [['city', 'zip_code', 'address', 'phone', 'url', 'email'], 'string', 'max' => 64],
            [['name'], 'unique'],
            [['user_id'], 'unique'],
            [
                ['phone'], PhoneInputValidator::class,
                'message' => Yii::t('app', 'El número de de teléfono debe ser un número de teléfono válido.'),
            ],
            [
                ['zip_code'], 'match',
                'pattern' => '/^[0-9]{5}(-[0-9]{4})?$/',
                'message' => Yii::t('app', 'El código postal debe ser un código postal válido. Ej. (14467 | 144679554 | 14467-9554)'),
            ],

            [['image'], 'file'],
            [['image'], 'safe'],
            [['email'], 'email'],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::class, 'targetAttribute' => ['country_id' => 'id']],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => States::class, 'targetAttribute' => ['state_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['user_id', 'name', 'country_id', 'state_id', 'city', 'zip_code', 'address', 'phone'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'Usuario vinculado'),
            'name' => Yii::t('app', 'Bodega'),
            'description' => Yii::t('app', 'Descripción'),
            'information' => Yii::t('app', 'Información adicional'),
            'image' => Yii::t('app', 'Logo corporativo'),
            'upload' => Yii::t('app', 'Logo corporativo'),
            'country_id' => Yii::t('app', 'País'),
            'state_id' => Yii::t('app', 'Estado o provincia'),
            'status_id' => Yii::t('app', 'Estado de la cuenta'),
            'city' => Yii::t('app', 'Ciudad'),
            'zip_code' => Yii::t('app', 'Código postal'),
            'address' => Yii::t('app', 'Dirección'),
            'phone' => Yii::t('app', 'Teléfono'),
            'email' => Yii::t('app', 'Correo electrónico'),
            'url' => Yii::t('app', 'Sitio web'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_at' => Yii::t('app', 'Socio desde '),
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
        return true;
    }

    /**
     * Sube la imagen de logo corporativo a Amazon Web Services S3.
     *
     * @return void
     */
    public function uploadImage()
    {
        $this->upload = UploadedFile::getInstance($this, 'upload');
        if ($this->upload !== null) {
            $this->image = AmazonS3::upload($this->upload, $this->id, AmazonS3::BUCKET_PARTNERS, $this->image);
            $this->upload = null;
        }
    }

    /**
     * Genera un enlace a la imagen de logo corporativo.
     *
     * @param   string    $link   enlace a imagen de logo corporativo.
     * @return  void
     */
    public function setLink($link)
    {
        $this->_link = $link;
    }

    /**
     * Genera un enlace a la imagen de logo corporativo.
     *
     * @return  string  enlace a imagen de logo corporativo.
     */
    public function getLink()
    {
        if ($this->_link === null && !$this->isNewRecord) {
            $this->setLink(AmazonS3::getLink($this->image, self::IMAGE, AmazonS3::PARTNERS, AmazonS3::BUCKET_PARTNERS));
        }
        return $this->_link;
    }

    public function setLocation($location)
    {
        $this->_location = $location;
    }

    public function getLocation()
    {
        if ($this->_location === null && !$this->isNewRecord) {
            $country = $this->getCountry()->one()->label;
            $state = $this->getState()->one()->label;
            $this->setLocation($this->address . ' ' . $state . ', ' . $country);
        }
        return $this->_location;
    }

    /**
     * Determina si el usuario tiene la cuenta activa.
     *
     * @return boolean  verdadero si el usuario tiene la cuenta activa.
     */
    public function isActive()
    {
        return $this->status_id === Status::STATUS_ACTIVE;
    }

    /**
     * Establece el stado del usuario como activo.
     *
     * @return void
     */
    public function setActive()
    {
        $this->status_id = Status::STATUS_ACTIVE;
    }

    /**
     * Establece el stado del usuario como no activo.
     *
     * @return void
     */
    public function setInactive()
    {
        $this->status_id = Status::STATUS_INACTIVE;
    }

    /**
     * Establece el stado del usuario como eliminado.
     *
     * @return void
     */
    public function setDeleted()
    {
        $this->status_id = Status::STATUS_DELETED;
    }

    /**
     * Obtiene consulta para [[Countries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::class, ['id' => 'country_id'])->inverseOf('partners');
    }

    /**
     * Obtiene consulta para [[States]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(States::class, ['id' => 'state_id'])->inverseOf('partners');
    }

    /**
     * Obtiene consulta para [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id'])->inverseOf('partners');
    }

    /**
     * Obtiene consulta para [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])->inverseOf('partners');
    }

    /**
     * Obtiene consulta para [[Followers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFollowers()
    {
        return $this->hasMany(Followers::class, ['partner_id' => 'id'])->inverseOf('partner');
    }

    /**
     * Obtiene consulta para [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable('followers', ['partner_id' => 'id']);
    }

    /**
     * Obtiene consulta para [[Articles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Articles::class, ['partner_id' => 'id'])->inverseOf('partner');
    }

    /**
     * Comprueba si el acceso del usuario es válido para determinada acción.
     *
     * @return boolean  verdadero si es coinciden los id's.
     */
    public static function isOwner()
    {
        return static::find()->where([
            'id' => intval(Yii::$app->getRequest()->getQueryParam('id')),
            'user_id' => intval(User::id()),
        ])->exists();
    }

    /**
     * Comprueba si el socio está activo.
     *
     * @return boolean  verdadero si el socio está activo.
     */
    public static function active()
    {
        $model = static::find()->where(['id' => intval(Yii::$app->getRequest()->getQueryParam('id'))]);
        if ($model->exists()) {
            return $model->one()->status_id === 3;
        } else {
            return false;
        }
    }

    /**
     * Genera una lista con las etiquetas de los objetos [[Partners]]
     *
     * @return array    array con las etiquetas de [[Partners]] indexados por id.
     */
    public static function labels()
    {
        return static::find()->select('name')->orderBy('name')->indexBy('id')->column();
    }
}
