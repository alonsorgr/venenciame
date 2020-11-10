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

/**
 * Modelo que representa el modelo detrás de la forma de búsqueda de [[Orders]].
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 3.0
 */
class OrdersSearch extends Orders
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status_id', 'user_id', 'dealer_id'], 'integer'],
            [['total_price'], 'number'],
            [['created_at'], 'safe'],
        ];
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
        $query = Orders::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status_id' => $this->status_id,
            'user_id' => $this->user_id,
            'dealer_id' => $this->dealer_id,
            'total_price' => $this->total_price,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}
