<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models;

use Yii;

/**
 * Esta es la clase modelo para la tabla "categorías".
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 2.0
 * @property int $id
 * @property string $label
 * @property string|null $created_at
 * 
 * @property Articles[] $articles
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['label'], 'required'],
            [['created_at'], 'safe'],
            [['label'], 'string', 'max' => 64],
            [['label'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Categoría'),
            'label' => Yii::t('app', 'Categoría'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Obtiene consulta para [[Articles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Articles::class, ['category_id' => 'id'])->inverseOf('category');
    }

    /**
     * Genera una lista con las etiquetas de los objetos [[Categories]]
     *
     * @return array    array con las etiquetas de [[Categories]] indexados por id.
     */
    public static function labels()
    {
        return static::find()->select('label')->orderBy('label')->indexBy('id')->column();
    }
}
