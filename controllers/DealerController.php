<?php

namespace app\controllers;

use app\models\search\OrderItemsSearch;
use app\models\search\OrdersSearch;
use app\models\User;
use Yii;
use yii\filters\AccessControl;

class DealerController extends Controller
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
                            return User::isAdmin() || User::isDealer();
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $ordersSearch = new OrdersSearch();
        $ordersProvider = $ordersSearch->search(Yii::$app->request->queryParams);

        $orderItemsSearch = new OrderItemsSearch();
        $orderItemsProvider = $orderItemsSearch->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'ordersSearch' => $ordersSearch,
            'ordersProvider' => $ordersProvider,
            'orderItemsSearch' => $orderItemsSearch,
            'orderItemsProvider' => $orderItemsProvider,
        ]);
    }

}
