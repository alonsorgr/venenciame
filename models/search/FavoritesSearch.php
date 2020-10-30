<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models\search;

use yii\data\ActiveDataProvider;
use app\models\Articles;

/**
 * Modelo que representa el modelo detrás de la forma de búsqueda de [[Articles]].
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 2.0
 */
class FavoritesSearch extends Articles
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'partner_id', 'category_id', 'denomination_id', 'vat_id', 'stock', 'capacity'], 'integer'],
            [['title', 'description', 'degrees', 'variety', 'pairing', 'review', 'image', 'created_at'], 'safe'],
            [['price'], 'number'],
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
        $query = Articles::find()->joinWith(['favorites f'], true)->where(['f.user_id' => $params['id']])->andWhere(['status_id' => 3]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'id' => $this->id,
            'partner_id' => $this->partner_id,
            'category_id' => $this->category_id,
            'denomination_id' => $this->denomination_id,
            'vat_id' => $this->vat_id,
            'price' => $this->price,
            'stock' => $this->stock,
            'capacity' => $this->capacity,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike', 'description', $this->description])
            ->andFilterWhere(['ilike', 'degrees', $this->degrees])
            ->andFilterWhere(['ilike', 'variety', $this->variety])
            ->andFilterWhere(['ilike', 'pairing', $this->pairing])
            ->andFilterWhere(['ilike', 'review', $this->review])
            ->andFilterWhere(['ilike', 'image', $this->image]);

        return $dataProvider;
    }
}
