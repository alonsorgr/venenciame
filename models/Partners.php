<?php

namespace app\models;

use Yii;
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
            [['user_id', 'name', 'country_id', 'state_id', 'city', 'zip_code', 'address', 'phone'], 'required'],
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
            'user_id' => Yii::t('app', 'User ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'information' => Yii::t('app', 'Information'),
            'image' => Yii::t('app', 'Image'),
            'country_id' => Yii::t('app', 'Country ID'),
            'state_id' => Yii::t('app', 'State ID'),
            'status_id' => Yii::t('app', 'Estado'),
            'city' => Yii::t('app', 'City'),
            'zip_code' => Yii::t('app', 'Zip Code'),
            'address' => Yii::t('app', 'Address'),
            'phone' => Yii::t('app', 'Phone'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Gets query for [[Country]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::class, ['id' => 'country_id'])->inverseOf('partners');
    }

    /**
     * Gets query for [[State]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(States::class, ['id' => 'state_id'])->inverseOf('partners');
    }

    /**
     * Gets query for [[Statuses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Statuses::class, ['id' => 'status_id'])->inverseOf('partners');
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])->inverseOf('partners');
    }
}
