<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models\search;

use yii\data\ActiveDataProvider;
use app\models\Vats;

/**
 * Modelo que representa el modelo detrás de la forma de búsqueda de [[Vats]].
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 2.0
 */
class VatsSearch extends Vats
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'value'], 'integer'],
            [['label', 'created_at'], 'safe'],
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
        $query = Vats::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'value' => $this->value,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['ilike', 'label', $this->label]);

        return $dataProvider;
    }
}
