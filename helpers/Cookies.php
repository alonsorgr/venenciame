<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\helpers;

use bizley\cookiemonster\CookieMonster;

/**
 * Clase auxiliar para la administración y generación de cookies.
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 */
class Cookies
{
    /**
     * Registra el mensaje de aceptación de cookies.
     *
     * @return string   el resultado de la representación.
     */
    public static function register()
    {
        return CookieMonster::widget([
            'mode' => 'custom',
            'box' => [
                'view' => '@app/views/site/cookies',
            ],
        ]);
    }
}
