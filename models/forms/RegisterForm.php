<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models\forms;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use app\models\User;
use app\helpers\Email;
use app\models\Statuses;

/**
 * Modelo para formulario de registro de usuarios.
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 */
class RegisterForm extends ActiveRecord
{
    /**
     * Atributo de nombre de usuario.
     *
     * @var string
     */
    public $username;

    /**
     * Atributo de contraseña de usuario.
     *
     * @var string
     */
    public $password;

    /**
     * Atributo de correo electrónico de usuario.
     *
     * @var string
     */
    public $email;

    /**
     * Atributo de privacidad de usuario.
     *
     * @var bool
     */
    public $privacity;

    /**
     * Atributo privado de usuario.
     *
     * @var User|null|false
     */
    private $_user = null;

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
            [
                ['username'], 'required',
                'message' => Yii::t('app', 'El campo de nombre de usuario no puede estar vacío.')
            ],
            [
                ['username'], 'match', 'pattern' => '/^[a-zA-Z0-9\.@]*$/i',
                'message' => Yii::t('app', 'El nombre de usuario sólo pueden contener caracteres (a-Z), números (0-9) y separados por puntos (.).')
            ],
            [
                ['username'], 'string', 'max' => 64,
                'message' => Yii::t('app', 'El campo de nombre de usuario no puede exceder los 64 caracteres.')
            ],
            [
                ['username'], 'unique',
                'message' => Yii::t('app', 'El nombre de usuario solicitado no está disponible.')
            ],
            [
                ['email'], 'required',
                'message' => Yii::t('app', 'El campo de la dirección de correo electrónico no puede estar vacío.')
            ],
            [
                ['email'], 'email',
                'message' => Yii::t('app', 'El campo de la dirección de correo electrónico debe ser una dirección de correo válida.')
            ],
            [
                ['email'], 'unique',
                'message' => Yii::t('app', 'El correo electrónico aportado ya se encuentra registrado.')
            ],
            [
                ['password'], 'required',
                'message' => Yii::t('app', 'El campo de contraseña no puede estar vacío.')
            ],
            [
                ['password', 'email'], 'string', 'max' => 64,
                'message' => Yii::t('app', 'El campo de nombre de usuario no puede exceder los 32 caracteres.')
            ],
            [
                ['privacity'], 'compare', 'compareValue' => true,
                'message' => Yii::t('app', 'Debe aceptar las condiciones de uso para poder completar el registro.')
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Nombre de usuario'),
            'password' => Yii::t('app', 'Contraseña'),
            'email' => Yii::t('app', 'Correo electrónico'),
            'privacity' => Yii::t('app', 'He leído y acepto la política de privacidad.'),
        ];
    }

    /**
     * Registra a un usuario en la aplicación.
     *
     * @return bool verdadero si el usuario se registra correctamente.
     */
    public function register()
    {
        if ($this->validate()) {
            $this->user->generatePasswordHash($this->password);
            $this->user->generateAuthKey();
            if ($this->user->save()) {
                Email::send([
                    'email' => $this->email,
                    'subject' => Yii::t('app', 'VENÉNCIAME - ACTIVAR CUENTA'),
                    'body' => Email::link([
                        'body' => Yii::t('app', 'Haga clic en el siguiente enlace para verificar su cuenta.'),
                        'url' => Url::to([
                            'activate-account',
                            'id' => $this->user->id,
                            'auth_key' => $this->user->auth_key,
                        ], true),
                        'text' => Yii::t('app', 'Verificar cuenta'),
                    ]),
                ]);
                return true;
            }
        }
        return false;
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
        if (is_null($this->_user)) {
            $this->setUser(new User([
                'username' => $this->username,
                'email' => $this->email,
                'status_id' => Statuses::STATUS_INACTIVE,
                'privacity' => $this->privacity
            ]));
        }

        return $this->_user;
    }
}
