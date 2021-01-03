<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * Modelo para formulario de conexión de usuarios.
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 */
class LoginForm extends Model
{
    /**
     * Atributo de nombre de usuario o correo electrónico.
     *
     * @var string
     */
    public $login;

    /**
     * Atributo de contraseña de usuario.
     *
     * @var string
     */
    public $password;

    /**
     * Atributo de guardado de sesión.
     *
     * @var boolean
     */
    public $rememberMe = true;

    /**
     * Atributo privado de usuario.
     *
     * @var User|null|false
     */
    private $_user = false;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['login'], 'required',
                'message' => Yii::t('app', 'El campo de nombre de usuario o correo electrónico no puede estar vacío.')
            ],
            [
                'login', 'match', 'pattern' => '/^[a-zA-Z0-9\.@]*$/i',
                'message' => Yii::t('app', 'El nombre de usuario o correo electrónico sólo pueden contener caracteres (a-Z), números (0-9) y separados por puntos (.).')
            ],
            [
                ['password'], 'required',
                'message' => Yii::t('app', 'El campo de contraseña no puede estar vacío.')
            ],
            //['login', 'isActive'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'login' => Yii::t('app', 'Nombre de usuario o correo electrónico'),
            'password' => Yii::t('app', 'Contraseña'),
            'rememberMe' => Yii::t('app', 'Mantener la sesión iniciada'),
        ];
    }

    /**
     * Valida la contraseña de usuario.
     *
     * @param string $attribute     Atributo de contraseña.
     * @return void
     */
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            if (!$this->user || !$this->user->validatePasswordHash($this->password)) {
                $this->addError($attribute, Yii::t('app', 'En nombre de usuario, correo electrónico o la contraseña son incorrectos.'));
            }
        }
    }

    /**
     * Comprueba que el usuario que desea conectarse está activo.
     *
     * @param string    $attribute      Atributo de login.
     * @return void
     */
    public function isActive($attribute)
    {
        if (!$this->hasErrors()) {
            if (!$this->user->isActive()) {
                $this->addError($attribute, Yii::t('app', 'Su cuenta se encuentra actualmente inactiva.'));
            }
        }
    }

    /**
     * Autentifica al usuario en la aplicación.
     *
     * @return bool verdadero si el usuario se autentifica correctamente.
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->user, $this->rememberMe ? 3600 * 24 * 30 : 0);
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
        if ($this->_user === false) {
            $user = User::findByUsername($this->login);
            if ($user !== null) {
                $this->setUser($user);
            } else {
                $user = User::findByEmail($this->login);
                $this->setUser($user);
            }
        }
        return $this->_user;
    }
}
