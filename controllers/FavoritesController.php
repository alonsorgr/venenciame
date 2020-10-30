<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Favorites;

/**
 * Controlador de favoritos.
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 */
class FavoritesController extends \yii\web\Controller
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
                        'actions' => ['set'],
                        'allow' => true,
                        'roles' => ['@'],

                    ],
                ],
            ],
        ];
    }

    /**
     * Acción de agragación de favoritos.
     *
     * @return string    objeto JSON.
     */
    public function actionSet($user_id, $article_id)
    {
        $model = new Favorites();
        $where = ['user_id' => $user_id, 'article_id' => $article_id];
        $exists = $model->find()->where($where)->exists();

        if (Yii::$app->request->isAjax && Yii::$app->request->isGet) {
            if ($exists) {
                return json_encode(['class' => 'fas', 'title' => Yii::t('app', 'Quitar de favoritos')]);
            } else {
                return json_encode(['class' => 'far', 'title' => Yii::t('app', 'Agregar a favoritos')]);
            }
        }

        if ($exists && $model->find()->where($where)->one()->delete()) {
            if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
                return json_encode(['class' => 'far', 'title' => Yii::t('app', 'Agregar a favoritos')]);
            }
        } else {
            $model->user_id = $user_id;
            $model->article_id = $article_id;
            if ($model->save()) {
                return json_encode(['class' => 'fas', 'title' => Yii::t('app', 'Quitar de favoritos')]);
            }
        }
    }

}
