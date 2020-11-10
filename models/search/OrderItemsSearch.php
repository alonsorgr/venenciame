<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OrderItems;

/**
 * Modelo que representa el modelo detrás de la forma de búsqueda de [[OrderItems]].
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 3.0
 */
class OrderItemsSearch extends OrderItems
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'article_id', 'quantity'], 'integer'],
            [['price'], 'number'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
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
        $query = OrderItems::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'article_id' => $this->article_id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}
