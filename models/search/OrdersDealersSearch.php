<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Orders;
use app\models\Roles;
use app\models\User;
use Yii;
use yii\rbac\Role;

/**
 * Modelo que representa el modelo detrás de la forma de búsqueda de [[Orders]].
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 3.0
 */
class OrdersDealersSearch extends Orders
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status_id', 'user_id', 'dealer_id'], 'integer'],
            [['total_price'], 'number'],
            [['created_at', 'user.username'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'dealer_id' => Yii::t('app', 'Repartidor'),
            'total_price' => Yii::t('app', 'Precio total'),
            'status_id' => Yii::t('app', 'Estado del pedido'),
            'created_at' => Yii::t('app', 'Creado el'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), ['user.username']);
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return parent::scenarios();
    }

    /**
     * Crea una instancia de proveedor de datos con la consulta de búsqueda aplicada.
     *
     * @param   array                   $params     parámetros URL.
     * @return  ActiveDataProvider      Proporciona datos realizando consultas a la base de datos mediante [[Query]].
     */
    public function search($params)
    {
        $query = Orders::find()->joinWith('user u')->where(['dealer_id' => User::id()]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['user.username'] = [
            'asc' => ['u.username' => SORT_ASC],
            'desc' => ['u.username' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'orders.id' => $this->id,
            'orders.status_id' => $this->status_id,
            'orders.user_id' => $this->user_id,
            'orders.dealer_id' => $this->dealer_id,
            'orders.total_price' => $this->total_price,
            'orders.created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['ilike', 'u.username', $this->getAttribute('user.username')]);

        return $dataProvider;
    }
}
