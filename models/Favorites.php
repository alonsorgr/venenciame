<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models;

use Yii;

/**
 * Esta es la clase modelo para la tabla "favorites".
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 2.0
 * @property int $id
 * @property int $user_id
 * @property int $article_id
 * @property string|null $created_at
 *
 * @property Articles $article
 * @property Users $user
 */
class Favorites extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favorites';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'article_id'], 'required'],
            [['user_id', 'article_id'], 'default', 'value' => null],
            [['user_id', 'article_id'], 'integer'],
            [['created_at'], 'safe'],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Articles::class, 'targetAttribute' => ['article_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'Usuario'),
            'article_id' => Yii::t('app', 'Vino'),
            'created_at' => Yii::t('app', 'Creado el'),
        ];
    }

    /**
     * Obtiene consulta para [[Articles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Articles::class, ['id' => 'article_id'])->inverseOf('favorites');
    }

    /**
     * Obtiene consulta para [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])->inverseOf('favorites');
    }
}
