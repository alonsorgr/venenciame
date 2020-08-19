<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "languages".
 *
 * @property int $id
 * @property string $code
 * @property string $label
 * @property string|null $created_at
 *
 * @property Users[] $users
 */
class Languages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'languages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'label'], 'required'],
            [['created_at'], 'safe'],
            [['code'], 'string', 'max' => 2],
            [['label'], 'string', 'max' => 64],
            [['code'], 'unique'],
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
            'code' => Yii::t('app', 'Code'),
            'label' => Yii::t('app', 'Label'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['language_id' => 'id'])->inverseOf('language');
    }
}
