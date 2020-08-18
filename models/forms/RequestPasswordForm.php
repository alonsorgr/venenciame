<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\User;
use yii\helpers\Url;
use app\helpers\Email;

class RequestPasswordForm extends Model
{
    /**
     * Atruibuto de correo electrónico del usuario.
     *
     * @var string
     */
    public $email = null;

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
                ['email'], 'required',
                'message' => Yii::t('app', 'El campo del correo electrónico no puede estar vacío.')
            ],
            [
                ['email'], 'email',
                'message' => Yii::t('app', 'El campo del correo electrónico debe ser un correo electrónico válido.')
            ],
            ['email', 'validateEmail'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'Coreeo electrónico'),
        ];
    }

    /**
     * Valida el correo electrónico del usuario.
     *
     * @param string $attribute     Atributo de correo electrónico.
     * @return void
     */
    public function validateEmail($attribute)
    {
        if (!$this->hasErrors()) {
            if (!$this->user) {
                $this->addError($attribute, Yii::t('app', 'La dirección de correo electrónico es una dirección de correo no válida.'));
            }
        }
    }

    /**
     * Genera una solicitud para el cambio de contraseña de usuario.
     *
     * @return bool verdadero si el cambio de contraseña se realiza correctamente.
     */
    public function request()
    {
        if ($this->validate()) {

            $this->user->generatePasswordVerfKey();

            $isSend = Email::send([
                'email' => $this->email,
                'subject' => Yii::t('app', 'VENÉNCIAME - RECUPERAR CONTRASEÑA'),
                'body' => Email::link([
                    'body' => Yii::t('app', 'Haga clic en el siguiente enlace para cambiar la contraseña.'),
                    'url' => Url::to([
                        'reset-password',
                        'id' => $this->user->id,
                        'verf_key' => $this->user->verf_key,
                    ], true),
                    'text' => Yii::t('app', 'Restablecer contraseña'),
                ]),
            ]);
            return $isSend && $this->user->save();
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
            $this->setUser(User::findByEmail($this->email));
        }
        return $this->_user;
    }
}
