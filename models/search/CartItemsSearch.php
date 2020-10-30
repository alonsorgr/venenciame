<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models\search;

use yii\data\ActiveDataProvider;
use app\models\CartItems;
use app\models\User;

/**
 * Modelo que representa el modelo detrás de la forma de búsqueda de [[CartItems]].
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 3.0
 */
class CartItemsSearch extends CartItems
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'article_id', 'status_id', 'quantity'], 'integer'],
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
     *
     * @return  ActiveDataProvider      Proporciona datos realizando consultas a la base de datos mediante [[Query]].
     */
    public function search($params)
    {
        $query = CartItems::find()->where(['user_id' => User::id()]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'article_id' => $this->article_id,
            'status_id' => $this->status_id,
            'quantity' => $this->quantity,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}
