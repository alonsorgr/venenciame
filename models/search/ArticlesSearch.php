<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Articles;

/**
 * ArticlesSearch represents the model behind the search form of `app\models\Articles`.
 */
class ArticlesSearch extends Articles
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
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Articles::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
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
