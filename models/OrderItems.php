<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models;

use Yii;

/**
 * Esta es la clase modelo para la tabla "orders".
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 3.0
 * @property int $id
 * @property int $article_id
 * @property int $quantity
 * @property float $price
 * @property string|null $created_at
 *
 * @property Orders $order
 * @property Articles $article
 */
class OrderItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_id', 'quantity', 'price'], 'required'],
            [['article_id', 'quantity'], 'default', 'value' => null],
            [['article_id', 'quantity'], 'integer'],
            [['price'], 'number'],
            [['created_at'], 'safe'],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Articles::class, 'targetAttribute' => ['article_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::class, 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'article_id' => Yii::t('app', 'Artículo'),
            'order_id' => Yii::t('app', 'Pedido'),
            'quantity' => Yii::t('app', 'Cantidad'),
            'price' => Yii::t('app', 'Precio'),
            'created_at' => Yii::t('app', 'Fecha'),
        ];
    }

    /**
     * Obtiene consulta para [[Articles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Articles::class, ['id' => 'article_id'])->inverseOf('orderItems');
    }

    /**
     * Obtiene consulta para [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::class, ['id' => 'order_id'])->inverseOf('orderItems');
    }
}
