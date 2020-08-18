<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\helpers;

use Yii;
use yii\web\View;
use yii\helpers\Url;
use yii\bootstrap4\Html;
use yii\web\Cookie;

/**
 * Clase auxiliar para la administración y generación de cookies.
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 */
class Cookies
{
    /**
     * Inicializa el consentimiento de uso de cookies.
     *
     * @param \yii\web\View     $view   vista donde se aplicará el consentimiento de cookies.
     * @return void
     */
    public static function init($view)
    {
        $url = Url::to(['site/cookie']);

        $title = Yii::t('app', 'Política de Cookies');
        $message = Html::tag('div', Yii::t('app', 'Utilizamos cookies para mejorar su experiencia de usuario. Por favor, acepte nuestra politica de cookies.'), [
            'class' => 'p-1',
        ]);

        $button = Yii::t('app', 'Aceptar');

        $view->registerJsFile("@web/js/bootbox.min.js", [
            'depends' => [
                \yii\web\JqueryAsset::class,
            ]
        ]);

        $js = <<<EOT
            bootbox.dialog({
                size: 'xl',
                title: '$title',
                message: '$message',
                locale: 'es',
                closeButton: false,
                buttons: {
                    accept: {
                        label: '$button',
                        className: 'btn-primary',
                        callback: function(){
                            window.location.replace('$url');              
                        }
                    },
                },
            });
        EOT;

        if (!Yii::$app->getRequest()->getCookies()->getValue('accept-cookies')) {
            $view->registerJs($js, View::POS_READY);
        }
    }

    /**
     * Genera una cookie para aceptación de términios.
     *
     * @return void
     */
    public static function accept()
    {
        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'accept-cookies',
            'value' => '1',
            'expire' => time() + 3600 * 24 * 365,
            'domain' => '',
        ]));
    }
}
