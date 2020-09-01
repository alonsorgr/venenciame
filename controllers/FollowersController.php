<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\controllers;

use Yii;
use app\models\Followers;
use app\models\search\FollowedSearch;
use app\models\search\FollowersSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Controlador de socios [[Followers]]
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 */
class FollowersController extends Controller
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
                        'actions' => ['follow'],
                        'allow' => true,
                        'roles' => ['@'],

                    ],
                ],
            ],
        ];
    }

    /**
     * Acción de seguimiento de socios.
     *
     * @return string    el resultado de la representación.
     */
    public function actionFollow($user_id, $partner_id)
    {
        $model = new Followers();
        $where = ['user_id' => $user_id, 'partner_id' => $partner_id];
        $exists = $model->find()->where($where)->exists();

        if (Yii::$app->request->isAjax && Yii::$app->request->isGet) {
            if ($exists) {
                return json_encode(['class' => 'fas', 'title' => Yii::t('app', 'Dejar de seguir')]);
            } else {
                return json_encode(['class' => 'far', 'title' => Yii::t('app', 'Seguir')]);
            }
        }

        if ($exists && $model->find()->where($where)->one()->delete()) {
            if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
                return json_encode(['class' => 'far', 'title' => Yii::t('app', 'Seguir')]);
            }
        } else {
            $model->user_id = $user_id;
            $model->partner_id = $partner_id;
            if ($model->save()) {
                return json_encode(['class' => 'fas', 'title' => Yii::t('app', 'Dejar de seguir')]);
            }
        }
    }
}
