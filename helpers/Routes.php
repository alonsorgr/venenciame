<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\helpers;

use Yii;

/**
 * Clase auxiliar para la administración y generación rutas.
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 */
class Routes
{
    /**
     * Devuelve el valor del parámetro id de una query.
     *
     * @param string $url   url para obtener id
     */
    public static function getId($url)
    {
        if (Yii::$app->urlManager->enablePrettyUrl) {
            return substr($url, strripos($url, '/') + 1);
        }
        $url = parse_url($url);
        return substr($url['query'], strripos($url['query'], '=') + 1);
    }
}
