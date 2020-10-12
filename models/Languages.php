<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models;

use Yii;

/**
 * Esta es la clase modelo para la tabla "Idiomas".
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 * @property int $id
 * @property string $code
 * @property string $label
 * @property string|null $created_at
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
     * Obtiene consulta para [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['language_id' => 'id'])->inverseOf('language');
    }

    /**
     * Genera una lista con las etiquetas de los objetos [[Languages]]
     *
     * @return array    array con las etiquetas de [[Languages]] indexados por id.
     */
    public static function labels()
    {
        return static::find()->select('label')->orderBy('label')->indexBy('id')->column();
    }
}
