<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\Reviews;

/**
 * Modelo que representa el modelo detrás de la forma de búsqueda de [[Reviews]].
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 2.0
 */
class ReviewsUserSearch extends Reviews
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'article_id', 'score'], 'integer'],
            [['review', 'created_at'], 'safe'],
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
        $query = Reviews::find()->where(['user_id' => intval(Yii::$app->getRequest()->getQueryParam('id'))]);

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
            'score' => $this->score,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['ilike', 'review', $this->review]);

        return $dataProvider;
    }
}
