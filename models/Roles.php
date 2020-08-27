<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models;

use Yii;

/**
 * Esta es la clase modelo para la tabla "roles".
 * 
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 * 
 * @property int $id
 * @property string $label
 * @property string|null $updated_at
 * @property string|null $created_at
 */
class Roles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['label'], 'required'],
            [['updated_at', 'created_at'], 'safe'],
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
            'id' => Yii::t('app', 'ID'),
            'label' => Yii::t('app', 'Label'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Genera una lista con las etiquetas de los objetos [[Roles]]
     *
     * @return array    array con las etiquetas de [[Roles]] indexados por id.
     */
    public static function labels()
    {
        return static::find()->select('label')->orderBy('label')->indexBy('id')->column();
    }
}
