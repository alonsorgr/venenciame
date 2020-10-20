<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models;

use Yii;

/**
 * Esta es la clase modelo para la tabla "denominaciones".
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 2.0
 * @property int $id
 * @property string $label
 * @property string|null $created_at
 */
class Denominations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'denominations';
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
            'id' => Yii::t('app', 'Denominación de origen'),
            'label' => Yii::t('app', 'Denominación de origen'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Genera una lista con las etiquetas de los objetos [[Denominations]]
     *
     * @return array    array con las etiquetas de [[Denominations]] indexados por id.
     */
    public static function labels()
    {
        return static::find()->select('label')->orderBy('label')->indexBy('id')->column();
    }
}
