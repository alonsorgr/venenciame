<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\controllers;

use app\models\search\AdminPartnersSearch;
use app\models\search\CategoriesSearch;
use app\models\search\PartnersSearch;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\User;
use app\models\search\UserSearch;

/**
 * Controlador de administración.
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 */
class AdminController extends Controller
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
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return User::isAdmin();
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Acción de renderizado vista de inicio de administradores.
     *
     * @return yii\web\Response | string    el resultado de la representación.
     */
    public function actionIndex()
    {       
        $userSearchModel = new UserSearch();
        $userDataProvider = $userSearchModel->search(Yii::$app->request->queryParams);

        $partnersSearchModel = new AdminPartnersSearch();
        $partnersDataProvider = $partnersSearchModel->search(Yii::$app->request->queryParams);

        $categoriesSearchModel = new CategoriesSearch();
        $categoriesDataProvider = $categoriesSearchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'userSearchModel' => $userSearchModel,
            'userDataProvider' => $userDataProvider,
            'partnersSearchModel' => $partnersSearchModel,
            'partnersDataProvider' => $partnersDataProvider,
            'categoriesSearchModel' => $categoriesSearchModel,
            'categoriesDataProvider' => $categoriesDataProvider,
        ]);
    }
}
