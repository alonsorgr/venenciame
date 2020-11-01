<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models\forms;

use Yii;
use borales\extensions\phoneInput\PhoneInputValidator;
use app\models\User;
use app\models\Countries;
use app\models\Partners;
use app\models\States;
use app\models\Status;
use yii\helpers\Url;
use app\helpers\Email;

/**
 * Modelo para formulario de solicitud de socio.
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 */
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
            [
                ['phone'], PhoneInputValidator::class,
                'message' => Yii::t('app', 'El número de de teléfono debe ser un número de teléfono válido.'),
            ],
            [
                ['zip_code'], 'match',
                'pattern' => '/^[0-9]{5}(-[0-9]{4})?$/',
                'message' => Yii::t('app', 'El código postal debe ser un código postal válido. Ej. (14467 | 144679554 | 14467-9554)'),
            ],
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
            'address' => Yii::t('app', 'Dirección'),
            'phone' => Yii::t('app', 'Teléfono'),
        ];
    }

    public function request()
    {
        if ($this->validate()) {
            Email::send([
                'email' => Yii::$app->params['adminEmail'],
                'subject' => Yii::t('app', 'SOLICITUD DE SOCIO'),
                'body' => Email::link([
                    'body' => Yii::t('app', 'Se ha creado una nueva solocitud de socio.'),
                    'url' => Url::to(['admin/index'], true),
                    'text' => Yii::t('app', 'Ir al panel de administración'),
                ]) .
                Email::link([
                    'body' => Yii::t('app', 'Comprobar perfil de socio.'),
                    'url' => Url::to(['user/view', 'id' => $this->user->id], true),
                    'text' => Yii::t('app', 'Comprobar'),
                ]) ,
            ]);
            $partner = new Partners([
                'user_id' => $this->user->id,
                'name' => $this->name,
                'country_id' => $this->country_id,
                'state_id' => $this->state_id,
                'status_id' => Status::STATUS_INACTIVE,
                'city' => $this->city,
                'zip_code' => $this->zip_code,
                'address' => $this->address,
                'phone' => $this->phone,
            ]);

            return $partner->save();
        }
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
