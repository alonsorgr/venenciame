<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models;

use Yii;

/**
 * Esta es la clase modelo para la tabla "IVA".
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 2.0
 * @property int $id
 * @property string $label
 * @property int $value
 * @property string|null $created_at
 * 
 * @property Articles[] $articles
 */
class Vats extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vats';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['label', 'value'], 'required'],
            [['value'], 'default', 'value' => null],
            [['value'], 'integer'],
            [['created_at'], 'safe'],
            [['label'], 'string', 'max' => 64],
            [['label'], 'unique'],
            [['value'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'IVA'),
            'label' => Yii::t('app', 'Nombre'),
            'value' => Yii::t('app', 'Valor'),
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
        return $this->hasMany(Articles::class, ['vat_id' => 'id'])->inverseOf('vat');
    }

    /**
     * Genera una lista con las etiquetas de los objetos [[Vats]]
     *
     * @return array    array con las etiquetas de [[Vats]] indexados por id.
     */
    public static function labels()
    {
        return static::find()->select('label')->orderBy('label')->indexBy('id')->column();
    }
}
