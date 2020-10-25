<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models;

use Yii;

/**
 * Esta es la clase modelo para la tabla "reviews".
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 2.0
 * @property int $id
 * @property int $user_id
 * @property int $article_id
 * @property string $review
 * @property int $score
 * @property string|null $created_at
 *
 * @property Articles $article
 * @property Users $user
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'article_id', 'review', 'score'], 'required'],
            [['user_id', 'article_id', 'score'], 'default', 'value' => null],
            [['user_id', 'article_id', 'score'], 'integer'],
            [['score'], 'in', 'range' => [1, 2, 3, 4, 5]],
            [['review'], 'string'],
            [['created_at'], 'safe'],
            [['user_id', 'article_id'], 'unique', 'targetAttribute' => ['user_id', 'article_id']],
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
            'review' => Yii::t('app', 'Comentario'),
            'score' => Yii::t('app', 'Puntuación'),
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
        return $this->hasOne(Articles::class, ['id' => 'article_id'])->inverseOf('reviews');
    }

    /**
     * Obtiene consulta para [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])->inverseOf('reviews');
    }
}
