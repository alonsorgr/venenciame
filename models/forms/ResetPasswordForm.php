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
 * Modelo para formulario de generación de recuperación de contraseña.
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 */
class ResetPasswordForm extends Model
{
    /**
     * Atributo privado de contraseña.
     *
     * @var string
     */
    public $password = null;

    /**
     * Atributo privado de repatición contraseña.
     *
     * @var string
     */
    public $passwordRepeat = null;

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
                ['password'], 'required',
                'message' => Yii::t('app', 'El campo de contraseña no puede estar vacío.')
            ],
            [
                ['password'], 'string', 'max' => 64,
                'message' => Yii::t('app', 'El campo de contraseña de usuario no puede exceder los 64 caracteres.')
            ],
            [
                ['passwordRepeat'], 'required',
                'message' => Yii::t('app', 'El campo de repetir contraseña no puede estar vacío.')
            ],
            [
                ['passwordRepeat'], 'string', 'max' => 64,
                'message' => Yii::t('app', 'El campo de repetir contraseña no puede exceder los 64 caracteres.')
            ],
            [
                ['passwordRepeat'],
                'compare',
                'compareAttribute' => 'password',
                'message' => Yii::t('app', 'Las contraseñas introducidas no coinciden.')
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'password' => Yii::t('app', 'Contraseña'),
            'passwordRepeat' => Yii::t('app', 'Repita la contraseña'),
        ];
    }

    /**
     * Genera una nueva contraseña de usuario.
     *
     * @return bool verdadero si el cambio de contraseña se realiza correctamente.
     */
    public function reset()
    {
        if ($this->validate()) {
            $this->user->removePasswordVerfKey();
            $this->user->generatePasswordHash($this->password);
            return $this->user->save();
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
     * @param   string $id    identificador del usuario.
     * @return  User         instancia del modelo [[User]].
     */
    public function getUser($id = null)
    {
        if ($this->_user === null) {
            $this->setUser(User::findById($id));
        }
        return $this->_user;
    }
}
