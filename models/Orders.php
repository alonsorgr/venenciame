<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models;

use Yii;

/**
 * Esta es la clase modelo para la tabla "order_items".
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 3.0
 * @property int $id
 * @property int|null $status_id
 * @property int $user_id
 * @property int|null $dealer_id
 * @property float $total_price
 * @property string|null $created_at
 *
 * @property OrderItems[] $orderItems
 * @property Status $status
 * @property Users $user
 * @property Users $dealer
 */
class Orders extends \yii\db\ActiveRecord
{
    private $_dealers;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status_id', 'user_id', 'dealer_id'], 'default', 'value' => null],
            [['status_id', 'user_id', 'dealer_id'], 'integer'],
            [['user_id', 'total_price'], 'required'],
            [['total_price'], 'number'],
            [['created_at'], 'safe'],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['dealer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['dealer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'status_id' => Yii::t('app', 'Estado'),
            'user_id' => Yii::t('app', 'Usuario'),
            'dealer_id' => Yii::t('app', 'Repartidor'),
            'total_price' => Yii::t('app', 'Precio total'),
            'created_at' => Yii::t('app', 'Fecha'),
        ];
    }

    /**
     * Establece el nombre del repartidor.
     *
     * @param string    $dealers    repartidor.
     * @return void
     */
    public function setDealers($dealers)
    {
        $this->_dealers = $dealers;
    }

    /**
     * Accede al nombre del repartidor asociado.
     *
     * @return string   nombre del repartidor asociado.
     */
    public function getDealers()
    {
        if ($this->_dealers === null && !$this->isNewRecord) {
            $this->setDealers(isset($this->getDealer()->one()->username) ? $this->getDealer()->one()->username : Yii::t('app', 'No asignado'));
        }
        return $this->_dealers;
    }

    /**
     * Obtiene consulta para [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id'])->inverseOf('orders');
    }

    /**
     * Obtiene consulta para [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])->inverseOf('orders');
    }

    /**
     * Obtiene consulta para [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDealer()
    {
        return $this->hasOne(User::class, ['id' => 'dealer_id'])->inverseOf('orders0');
    }

    /**
     * Obtiene consulta para [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItems::class, ['order_id' => 'id'])->inverseOf('order');
    }
}
