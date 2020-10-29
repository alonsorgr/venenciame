<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models;

use Yii;

/**
 * Esta es la clase modelo para la tabla "cart_items".
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 3.0
 * @property int $id
 * @property int $user_id
 * @property int $article_id
 * @property int $status_id
 * @property int $quantity
 * @property string|null $created_at
 *
 * @property Articles $article
 * @property Statuses $status
 * @property User $user
 */
class CartItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cart_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'article_id', 'quantity'], 'required'],
            [['user_id', 'article_id', 'status_id', 'quantity'], 'default', 'value' => null],
            [['user_id', 'article_id', 'status_id', 'quantity'], 'integer'],
            [['created_at'], 'safe'],
            [['user_id', 'article_id'], 'unique', 'targetAttribute' => ['user_id', 'article_id']],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Articles::class, 'targetAttribute' => ['article_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Statuses::class, 'targetAttribute' => ['status_id' => 'id']],
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
            'user_id' => Yii::t('app', 'User ID'),
            'article_id' => Yii::t('app', 'Article ID'),
            'status_id' => Yii::t('app', 'Status ID'),
            'quantity' => Yii::t('app', 'Quantity'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Obtiene consulta para [[Articles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Articles::class, ['id' => 'article_id'])->inverseOf('cartItems');
    }

    /**
     * Obtiene consulta para [[Statuses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Statuses::class, ['id' => 'status_id'])->inverseOf('cartItems');
    }

    /**
     * Obtiene consulta para [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])->inverseOf('cartItems');
    }
}
