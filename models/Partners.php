<?php

namespace app\models;

use Yii;
use app\helpers\AmazonS3;
use yii\web\UploadedFile;
use borales\extensions\phoneInput\PhoneInputValidator;

/**
 * This is the model class for table "partners".
 *
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
 * @property string|null $updated_at
 * @property string $created_at
 *
 * @property Countries $country
 * @property States $state
 * @property Statuses $status
 * @property Users $user
 */
class Partners extends \yii\db\ActiveRecord
{
    /**
     * Constante de imagen de logo corporativo.
     */
    const IMAGE = '@img/partners.jpg';

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
            [['city', 'zip_code', 'address', 'phone'], 'string', 'max' => 64],
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
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Statuses::class, 'targetAttribute' => ['status_id' => 'id']],
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
            'name' => Yii::t('app', 'Nombre de la bodega o empresa'),
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
            $this->image = AmazonS3::upload($this->upload, $this->name, AmazonS3::BUCKET_USERS, $this->image);
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
        }
        $this->setLink(AmazonS3::getLink($this->image, self::IMAGE, AmazonS3::USER, AmazonS3::BUCKET_USERS));
        return $this->_link;
    }

    /**
     * Relación de partners con [[Countries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::class, ['id' => 'country_id'])->inverseOf('partners');
    }

    /**
     * Relación de partners con [[States]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(States::class, ['id' => 'state_id'])->inverseOf('partners');
    }

    /**
     * Relación de partners con [[Statuses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Statuses::class, ['id' => 'status_id'])->inverseOf('partners');
    }

    /**
     * Relación de partners con [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])->inverseOf('partners');
    }
}
