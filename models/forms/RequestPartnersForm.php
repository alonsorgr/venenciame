<?php

namespace app\models\forms;

use Yii;
use app\models\User;
use app\models\Countries;
use app\models\States;

class RequestPartnersForm extends \yii\db\ActiveRecord
{
    /**
     * Atributo de nombre de [[Partners]].
     *
     * @var string
     */
    public $name;

    /**
     * Atributo de país de [[Partners]].
     *
     * @var int
     */
    public $country_id;

    /**
     * Atributo de estado o provincia de [[Partners]].
     *
     * @var int
     */
    public $state_id;

    /**
     * Atributo de ciudad de [[Partners]].
     *
     * @var string
     */
    public $city;

    /**
     * Atributo de código postal de [[Partners]].
     *
     * @var string
     */
    public $zip_code;

    /**
     * Atributo de dirección de [[Partners]].
     *
     * @var string
     */
    public $address;

    /**
     * Atributo de teléfono de [[Partners]].
     *
     * @var string
     */
    public $phone;

    /**
     * Atributo privado de usuario.
     *
     * @var User|null
     */
    private $_user = null;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['name', 'country_id', 'state_id', 'city', 'zip_code', 'address', 'phone'],
                'required',
                'message' => Yii::t('app', 'El {attribute} no puede estar vacío.'),
            ],
            [
                ['name'], 'unique',
                'message' => Yii::t('app', 'El nombre solicitado no está disponible.')
            ],
            [
                ['name'], 'string', 'max' => 32,
                'message' => Yii::t('app', 'El número de caracteres del {attribute} no puede exceder los 32 caracteres.'),
            ],
            [
                ['city', 'zip_code', 'address', 'phone'], 'string', 'max' => 64,
                'message' => Yii::t('app', 'El número de caracteres del {attribute} no puede exceder los 64 caracteres.'),
            ],
            [['country_id', 'state_id'], 'default', 'value' => null],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::class, 'targetAttribute' => ['country_id' => 'id']],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => States::class, 'targetAttribute' => ['state_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Nombre de la bodega o empresa'),
            'country_id' => Yii::t('app', 'País'),
            'state_id' => Yii::t('app', 'Estado o provincia'),
            'city' => Yii::t('app', 'Ciudad'),
            'zip_code' => Yii::t('app', 'Código postal'),
            'address' => Yii::t('app', 'Calle'),
            'phone' => Yii::t('app', 'Teléfono'),
        ];
    }

    /**
     * Establece el atributo [[$_user]].
     *
     * @param   User    $user    instancia del modelo [[User]].
     * @return  void
     */
    public function setUser($user)
    {
        $this->_user = $user;
    }

    /**
     * Accede al atributo [[$_user]].
     *
     * @return User instancia del modelo [[User]].
     */
    public function getUser()
    {
        if ($this->_user === null) {
            $this->setUser(User::findById(User::id()));
        }
        return $this->_user;
    }
}
