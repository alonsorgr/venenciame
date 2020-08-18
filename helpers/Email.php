<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\helpers;

use Yii;

/**
 * Clase auxiliar para la administración y generación de correo electrónico.
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 */
class Email
{
    /**
     * Genera y envía un correo electrónico.
     *
     * @return array configuración de elementos de correo electrónico.
     */
    public static function send($options)
    {
        return Yii::$app->mailer->compose('layouts/html', [
            'content' => $options['body'],
        ])->setFrom(Yii::$app->params['smtpUsername'])
            ->setTo($options['email'])
            ->setSubject($options['subject'])
            ->setHtmlBody($options['body'])
            ->send();
    }

    /**
     * Genera un enlace en para redireccionar hacia una acción de un correo electrónico.
     *
     * @return array configuración de elementos del enlace de correo electrónico.
     */
    public static function link($options)
    {
        return <<<EOT
            <h1>Venénciame</h1>
            <p>{$options['body']}<p>
            <a href="{$options['url']}">{$options['text']}</a>
        EOT;
    }
}
