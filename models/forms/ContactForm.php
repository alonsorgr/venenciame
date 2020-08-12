<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\helpers\Email;

/**
 * Modelo para formulario de contacto.
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 */
class ContactForm extends Model
{
    /**
     * Atributo de nombre y apellidos.
     *
     * @var string
     */
    public $name;

    /**
     * Atributo de correo electrónico del destinatario.
     *
     * @var string
     */
    public $email;

    /**
     * Atributo de asunto del correo electrónico.
     *
     * @var string
     */
    public $subject;

    /**
     * Atributo de cuerpo del correo electrónico.
     *
     * @var string
     */
    public $body;

    /**
     * Atributo de código de verificación.
     *
     * @var yii\captcha\CaptchaAction
     */
    public $verifyCode;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'subject', 'body'], 'required'],
            ['email', 'email'],
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Nombre completo'),
            'email' => Yii::t('app', 'Dirección de correo electrónico'),
            'subject' => Yii::t('app', 'Asunto'),
            'body' => Yii::t('app', 'Mensaje'),
            'verifyCode' => Yii::t('app', 'Código de verificación'),
        ];
    }

    public function contact()
    {
        if ($this->validate()) {
            return Email::send([
                'email' => Yii::$app->params['adminEmail'],
                'subject' => $this->subject,
                'body' => $this->body,
            ]);
        }
        return false;
    }
}
