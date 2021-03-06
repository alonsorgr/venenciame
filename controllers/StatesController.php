<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use app\models\States;

/**
 * Controlador de estados [[States]]
 * 
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 */
class StatesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['states'],
                        'allow' => true,
                        'roles' => ['@'],

                    ],
                ],
            ],
        ];
    }

    /**
     * Acción de volcado de datos de estados o provincias.
     * 
     * @param   int   $id   identificador del país.
     * @return  array       el objeto de respuesta actual.
     */
    public function actionStates($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return States::find()
            ->select('label')
            ->where(['country_id' => $id])
            ->orderBy('label')
            ->indexBy('id')
            ->column();
    }
}
