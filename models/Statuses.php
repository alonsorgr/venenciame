<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models;

use Yii;

/**
 * Esta es la clase modelo para la tabla "statuses".
 * 
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 * 
 * @property int $id
 * @property string $label
 * @property string|null $created_at
 */
class Statuses extends \yii\db\ActiveRecord
{
    /**
     * Constantes de estados
     */
    const STATUS_DELETED = 1;
    const STATUS_INACTIVE = 2;
    const STATUS_MODERATION = 3;
    const STATUS_PUBLISHED = 4;
    const STATUS_ACTIVE = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'statuses';
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
            'id' => Yii::t('app', 'ID'),
            'label' => Yii::t('app', 'Estado'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Obtiene consulta para [[Partners]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPartners()
    {
        return $this->hasMany(Partners::class, ['status_id' => 'id'])->inverseOf('status');
    }

    /**
     * Genera una lista con las etiquetas de los objetos [[Statuses]]
     *
     * @return array    array con las etiquetas de [[Statuses]] indexados por id.
     */
    public static function labels()
    {
        return static::find()->select('label')->orderBy('label')->indexBy('id')->column();
    }
}
