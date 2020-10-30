<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models\search;

use yii\data\ActiveDataProvider;
use app\models\Partners;

/**
 * Modelo que representa el modelo detrás de la forma de búsqueda de [[Partners]].
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 */
class AdminPartnersSearch extends Partners
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'country_id','state_id', 'status_id'], 'integer'],
            [['name', 'description', 'information', 'image', 'city', 'zip_code', 'address', 'phone', 'url', 'email', 'updated_at', 'created_at', 'user.username'], 'safe'],
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
     * {@inheritdoc}
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), ['user.username']);
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
        $query = Partners::find()->joinWith('user u');

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
            'partners.id' => $this->id,
            'partners.user_id' => $this->user_id,
            'partners.country_id' => $this->country_id,
            'partners.state_id' => $this->state_id,
            'partners.status_id' => $this->status_id,
            'partners.updated_at' => $this->updated_at,
            'partners.created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['ilike', 'partners.name', $this->name])
            ->andFilterWhere(['ilike', 'partners.description', $this->description])
            ->andFilterWhere(['ilike', 'partners.information', $this->information])
            ->andFilterWhere(['ilike', 'partners.image', $this->image])
            ->andFilterWhere(['ilike', 'partners.city', $this->city])
            ->andFilterWhere(['ilike', 'partners.zip_code', $this->zip_code])
            ->andFilterWhere(['ilike', 'partners.address', $this->address])
            ->andFilterWhere(['ilike', 'partners.phone', $this->phone])
            ->andFilterWhere(['ilike', 'partners.url', $this->url])
            ->andFilterWhere(['ilike', 'partners.email', $this->email])
            ->andFilterWhere(['ilike', 'u.username', $this->getAttribute('user.username')]);

        return $dataProvider;
    }
}
