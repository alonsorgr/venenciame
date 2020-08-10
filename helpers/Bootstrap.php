<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\helpers;

use yii\bootstrap4\Html;

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
}
