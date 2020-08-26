<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "statuses".
 *
 * @property int $id
 * @property string $label
 * @property string|null $created_at
 */
class Statuses extends \yii\db\ActiveRecord
{
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
     * Relación de 3estados con [[Partners]].
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
