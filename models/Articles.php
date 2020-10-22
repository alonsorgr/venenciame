<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models;

use Yii;

/**
 * Esta es la clase modelo para la tabla "articles".
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 2.0
 * @property int $id
 * @property int $partner_id
 * @property int $category_id
 * @property int $denomination_id
 * @property int $vat_id
 * @property string $title
 * @property string $description
 * @property float $price
 * @property int $stock
 * @property string $degrees
 * @property int $capacity
 * @property string $variety
 * @property string $pairing
 * @property string $review
 * @property string|null $image
 * @property string|null $created_at
 *
 * @property Categories $category
 * @property Denominations $denomination
 * @property Partners $partner
 * @property Vats $vat
 */
class Articles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['partner_id', 'category_id', 'denomination_id', 'vat_id', 'title', 'description', 'price', 'stock', 'degrees', 'capacity', 'variety', 'pairing', 'review'], 'required'],
            [['partner_id', 'category_id', 'denomination_id', 'vat_id', 'stock', 'capacity'], 'default', 'value' => null],
            [['partner_id', 'category_id', 'denomination_id', 'vat_id', 'stock', 'capacity'], 'integer'],
            [['price'], 'number'],
            [['review'], 'string'],
            [['created_at'], 'safe'],
            [['title', 'description', 'degrees', 'variety', 'pairing'], 'string', 'max' => 50],
            [['image'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'id']],
            [['denomination_id'], 'exist', 'skipOnError' => true, 'targetClass' => Denominations::class, 'targetAttribute' => ['denomination_id' => 'id']],
            [['partner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Partners::class, 'targetAttribute' => ['partner_id' => 'id']],
            [['vat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vats::class, 'targetAttribute' => ['vat_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'partner_id' => Yii::t('app', 'Bodega'),
            'category_id' => Yii::t('app', 'Tipo de vino'),
            'denomination_id' => Yii::t('app', 'Denominación de origen'),
            'vat_id' => Yii::t('app', 'Tipo de IVA'),
            'title' => Yii::t('app', 'Título'),
            'description' => Yii::t('app', 'Descripción'),
            'price' => Yii::t('app', 'Precio'),
            'stock' => Yii::t('app', 'Stock'),
            'degrees' => Yii::t('app', 'Graduación alcohólica'),
            'capacity' => Yii::t('app', 'Capacidad'),
            'variety' => Yii::t('app', 'Variedad'),
            'pairing' => Yii::t('app', 'Marinado'),
            'review' => Yii::t('app', 'Opinión de Venénciame'),
            'image' => Yii::t('app', 'Imagen'),
            'created_at' => Yii::t('app', 'Creado el'),
        ];
    }

    /**
     * Obtiene consulta para [[Categoiries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id'])->inverseOf('articles');
    }

    /**
     * Obtiene consulta para [[Denominations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDenomination()
    {
        return $this->hasOne(Denominations::class, ['id' => 'denomination_id'])->inverseOf('articles');
    }

    /**
     * Obtiene consulta para [[Partners]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPartner()
    {
        return $this->hasOne(Partners::class, ['id' => 'partner_id'])->inverseOf('articles');
    }

    /**
     * Obtiene consulta para [[Vats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVat()
    {
        return $this->hasOne(Vats::class, ['id' => 'vat_id'])->inverseOf('articles');
    }
}
