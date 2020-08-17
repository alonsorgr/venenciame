<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\helpers;

use kartik\dialog\Dialog;
use Yii;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;
use yii\web\View;

/**
 * Clase auxiliar para la administración y generación de elementos Html.
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 */
class Bootstrap
{
    /**
     * Genera una plantilla para elementos de entrada de texto con imagen y opción para mostrar u ocultar la contraseña.
     *
     * @param   array   $options    array de opciones.
     * @return  string              plantilla para elementos de entrada de texto con imagen y opción para mostrar u ocultar la contraseña.
     */
    public static function inputTemplate($options = [])
    {
        $options['image'] = isset($options['image']) ?
            $options['image'] = Html::tag('i', null, [
                'class' => $options['image'] . ' text-primary input-image',
            ]) :
            $options['image'] = '';

        $options['type-password'] = isset($options['type-password']) && $options['type-password'] === true ?
            $options['type-password'] = Html::tag('i', null, [
                'id' => 'password-input-icon',
                'class' => 'input-group-addon password-input-icon fas fa-eye-slash',
                'title' => Yii::t('app', 'Mostrar u ocultar contraseña'),
            ]) :
            $options['type-password'] = '';

        return <<<EOT
        {beginLabel}{labelTitle}{endLabel}
        <div class="input-group">
            {$options['image']}
            <div class="w-100">
                {input}
                {error}  
            </div>
            <div id="password-input">
                {$options['type-password']}
            </div>
            {hint}
        </div>
        EOT;
    }

    /**
     * Regitra el efecto de carga de peticiones.
     *
     * @param \yii\web\View    $view   vista donde se registrará la función.
     * @return void
     */
    public static function registerLoadingEffect($view)
    {
        $view->registerJsFile("@web/js/effects.js", [
            'depends' => [
                \yii\web\JqueryAsset::class,
            ]
        ]);

        $view->registerJs("loading()", View::POS_READY);
    }

    /**
     * Registra el diseño de los Tooltips de Bootstrap.
     *
     * @param \yii\web\View     $view   vista donde se registrará la función.
     * @return void
     */
    public static function registerTooltip($view)
    {
        $js = <<<EOT
                $(function () {
                    $('*').tooltip({
                        'delay': { show: 1000, hide: 0 }
                    });
                });
            EOT;
        $view->registerJs($js);
    }

    /**
     * Genera una ventana modal (widget) en respurestas AJAX.
     *
     * @param   array                   $options    opciones de configuración de la ventana modal {id, image, title}.
     * @return  \yii\bootstrap4\Widget              widget de ventana modal.
     */
    public static function modal($options)
    {
        Modal::begin([
            'id' => $options['id'],
            'title' => '<i class="' . $options['image'] . ' mr-3 ml-2"></i>' . $options['title'],
            'size' => !isset($options['size']) ?: $options['size'],
            'clientOptions' => ['method' => 'POST'],
        ]);
        echo Html::tag('div', null, [
            'id' => 'content',
        ]);
        Modal::end();
    }
}
