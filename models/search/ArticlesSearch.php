<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\Articles;
use app\models\Statuses;

/**
 * Modelo que representa el modelo detrás de la forma de búsqueda de [[Articles]].
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 2.0
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
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'partner_id' => Yii::t('app', 'Bodega'),
            'category_id' => Yii::t('app', 'Tipo de vino'),
            'denomination_id' => Yii::t('app', 'Denominación de origen'),
            'vat_id' => Yii::t('app', 'Tipo de IVA'),
            'title' => Yii::t('app', 'Nombre'),
            'description' => Yii::t('app', 'Descripción'),
            'price' => Yii::t('app', 'Precio máximo'),
            'degrees' => Yii::t('app', 'Graduación alcohólica máxima'),
            'capacity' => Yii::t('app', 'Capacidad'),
            'variety' => Yii::t('app', 'Variedad'),
            'pairing' => Yii::t('app', 'Maridaje'),
            'review' => Yii::t('app', 'Opinión del vendedor'),
            'image' => Yii::t('app', 'Imagen'),
            'upload' => Yii::t('app', 'Subir imagen del artículo'),
            'status_id' => Yii::t('app', 'Estado del artículo'),
            'created_at' => Yii::t('app', 'Creado el'),
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
        $query = Articles::find()->where(['status_id' => Statuses::STATUS_ACTIVE]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'articles.id' => $this->id,
            'articles.partner_id' => $this->partner_id,
            'articles.category_id' => $this->category_id,
            'articles.denomination_id' => $this->denomination_id,
            'articles.vat_id' => $this->vat_id,
            'articles.stock' => $this->stock,
            'articles.capacity' => $this->capacity,
            'articles.created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['ilike', 'articles.title', $this->title])
            ->andFilterWhere(['ilike', 'articles.description', $this->description])
            ->andFilterWhere(['ilike', 'articles.degrees', $this->degrees])
            ->andFilterWhere(['ilike', 'articles.variety', $this->variety])
            ->andFilterWhere(['ilike', 'articles.pairing', $this->pairing])
            ->andFilterWhere(['ilike', 'articles.review', $this->review])
            ->andFilterWhere(['<=', 'articles.price', $this->price])
            ->andFilterWhere(['ilike', 'articles.image', $this->image]);

        return $dataProvider;
    }
}
