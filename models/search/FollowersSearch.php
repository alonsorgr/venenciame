<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * Modelo que representa el modelo detrás de la forma de búsqueda de [[User]].
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 */
class FollowersSearch extends User
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'rol_id', 'language_id'], 'integer'],
            [['username', 'password', 'email', 'auth_key', 'verf_key', 'name', 'surname', 'birthdate', 'image', 'updated_at', 'created_at'], 'safe'],
            [['admin', 'privacity'], 'boolean'],
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
        $query = User::find()->joinWith(['followers f', 'partners p'], true)->where(['p.id' => $params['id']]);;

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
            'status' => $this->status,
            'admin' => $this->admin,
            'privacity' => $this->privacity,
            'birthdate' => $this->birthdate,
            'rol_id' => $this->rol_id,
            'language_id' => $this->language_id,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['ilike', 'username', $this->username])
            ->andFilterWhere(['ilike', 'password', $this->password])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'auth_key', $this->auth_key])
            ->andFilterWhere(['ilike', 'verf_key', $this->verf_key])
            ->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'surname', $this->surname])
            ->andFilterWhere(['ilike', 'image', $this->image]);

        return $dataProvider;
    }
}
