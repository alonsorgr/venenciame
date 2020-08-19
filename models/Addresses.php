<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models;

use borales\extensions\phoneInput\PhoneInputValidator;
use Yii;

/**
 * This is the model class for table "addresses".
 *
 * @property int $id
 * @property int $user_id
 * @property string $alias
 * @property string $identity
 * @property int $country_id
 * @property int $state_id
 * @property string $city
 * @property string $zip_code
 * @property string $address
 * @property string $phone
 * @property string|null $updated_at
 * @property string|null $created_at
 *
 * @property Countries $country
 * @property States $state
 * @property Users $user
 */
class Addresses extends \yii\db\ActiveRecord
{
    /**
     * Atributo de nombre de país.
     *
     * @var string
     */
    private $_country_name;

    /**
     * Atributo de nombre de estado o provincia.
     *
     * @var string
     */
    private $_state_name;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'addresses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['user_id', 'alias', 'identity', 'country_id', 'state_id', 'city', 'zip_code', 'address', 'phone'], 'required',
                'message' => Yii::t('app', 'El {attribute} no puede estar vacío.'),
            ],
            [['user_id', 'country_id', 'state_id'], 'default', 'value' => null],
            [
                ['user_id', 'country_id', 'state_id'], 'integer',
                'message' => Yii::t('app', 'El {attribute} tiene que ser un número entero.'),
            ],
            [['updated_at', 'created_at'], 'safe'],
            [
                ['phone'], PhoneInputValidator::class,
                'message' => Yii::t('app', 'El {attribute} tiene que ser un número de teléfono válido.'),
            ],
            [
                ['alias', 'identity', 'city', 'zip_code', 'address', 'phone'], 'string', 'max' => 64,
                'message' => Yii::t('app', 'El {attribute} no puede exceder los 64 caracteres.'),
            ],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::class, 'targetAttribute' => ['country_id' => 'id']],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => States::class, 'targetAttribute' => ['state_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'alias' => Yii::t('app', 'Receptor del envío'),
            'identity' => Yii::t('app', 'Número de identificación'),
            'country_id' => Yii::t('app', 'País'),
            'country_name' => Yii::t('app', 'País'),
            'state_id' => Yii::t('app', 'Estado o provincia'),
            'state_name' => Yii::t('app', 'Estado o provincia'),
            'city' => Yii::t('app', 'Ciudad'),
            'zip_code' => Yii::t('app', 'Código postal'),
            'address' => Yii::t('app', 'Dirección del receptor'),
            'phone' => Yii::t('app', 'Teléfono'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Establece el nombre del país [[Countries]].
     *
     * @param string    $name   nombre del país [[Countries]].  
     * @return void
     */
    public function setCountryName($name)
    {
        $this->_country_name = $name;
    }

    /**
     * Accede al nombre del país [[Countries]].
     *
     * @return string   nombre del país [[Countries]].
     */
    public function getCountryName()
    {
        if ($this->_country_name === null && !$this->isNewRecord) {
            $this->setCountryName($this->getCountry()->one()->label);
        }
        return $this->_country_name;
    }

    /**
     * Establece el nombre del estado [[States]].
     *
     * @param string    $name   nombre del estado [[States]].  
     * @return void
     */
    public function setStateName($name)
    {
        $this->_state_name = $name;
    }

    /**
     * Accede al nombre del estado [[States]].
     *
     * @return string   nombre del estado [[States]].
     */
    public function getStateName()
    {
        if ($this->_state_name === null && !$this->isNewRecord) {
            $this->setStateName($this->getState()->one()->label);
        }
        return $this->_state_name;
    }

    /**
     * Relación de addresses con [[Countries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::class, ['id' => 'country_id']);
    }

    /**
     * Relación de addresses con [[States]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(States::class, ['id' => 'state_id']);
    }

    /**
     * Relación de addresses con [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
