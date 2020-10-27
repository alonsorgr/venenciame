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
class UserSearch extends User
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status_id', 'rol_id', 'language_id'], 'integer'],
            [['username', 'password', 'email', 'auth_key', 'verf_key', 'name', 'surname', 'birthdate', 'image', 'updated_at', 'created_at', 'status.label'], 'safe'],
            [['admin', 'privacity'], 'boolean'],
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
        return array_merge(parent::attributes(), ['status.label']);
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
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['status.label'] = [
            'asc' => ['s.label' => SORT_ASC],
            'desc' => ['s.label' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'users.id' => $this->id,
            'users.status_id' => $this->status_id,
            'users.admin' => $this->admin,
            'users.privacity' => $this->privacity,
            'users.birthdate' => $this->birthdate,
            'users.rol_id' => $this->rol_id,
            'users.language_id' => $this->language_id,
            'users.updated_at' => $this->updated_at,
            'users.created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['ilike', 'users.username', $this->username])
            ->andFilterWhere(['ilike', 'users.password', $this->password])
            ->andFilterWhere(['ilike', 'users.email', $this->email])
            ->andFilterWhere(['ilike', 'users.auth_key', $this->auth_key])
            ->andFilterWhere(['ilike', 'users.verf_key', $this->verf_key])
            ->andFilterWhere(['ilike', 'users.name', $this->name])
            ->andFilterWhere(['ilike', 'users.surname', $this->surname])
            ->andFilterWhere(['ilike', 'users.image', $this->image])
            ->andFilterWhere(['ilike', 's.label', $this->getAttribute('status.label')]);

        return $dataProvider;
    }
}
