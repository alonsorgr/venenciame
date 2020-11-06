<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\controllers;

use Yii;

/**
 * Controlador principal.
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 3.0
 */
class Controller extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        $identity = Yii::$app->user->identity;

        if ($identity !== null) {
            if ($identity->language_id == 1) {
                Yii::$app->language = 'es-ES';
            } elseif ($identity->language_id == 2) {
                Yii::$app->language = 'en-GB';
            } elseif ($identity->language_id == 3) {
                Yii::$app->language = 'de-DE';
            } elseif ($identity->language_id == 4) {
                Yii::$app->language = 'fr-FR';
            } elseif ($identity->language_id == 5) {
                Yii::$app->language = 'pt-PT';
            } else {
                Yii::$app->language = 'es-ES';
            }
        }
    }
}
