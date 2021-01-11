<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\models;

use app\helpers\AmazonS3;
use Yii;
use yii\web\UploadedFile;

/**
 * Esta es la clase modelo para la tabla "articles".
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 2.0
 * @property int $id
 * @property int $partner_id
 * @property int $category_id
 * @property int $denomination_id
 * @property int $vat_id
 * @property string $name_id
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
 * @property Status $status
 * @property Vats $vat
 * @property Favorites[] $favorites
 * @property Reviews[] $reviews
 * @property CartItems[] $cartItems
 * @property OrderItems[] $orderItems
 */
class Articles extends \yii\db\ActiveRecord
{
    /**
     * Constante de imagen de perfil de usuario.
     */
    const IMAGE = '@web/img/articles.jpg';

    /**
     * Variable de subida de imagen de perfil de usuario.
     *
     * @var string
     */
    public $upload;

    /**
     * Atributo virtual para enlace a imagen de perfil.
     *
     * @var string
     */
    private $_link = null;

    /**
     * Atributo para el precio con iva.
     *
     * @var string
     */
    private $_amount = null;

    /**
     * Atributo de puntuación total.
     *
     * @var float
     */
    private $_score = null;

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
            [['category_id', 'denomination_id', 'vat_id', 'name_id', 'title', 'description', 'price', 'stock', 'degrees', 'capacity', 'variety', 'pairing', 'review'], 'required'],
            [['partner_id', 'category_id', 'denomination_id', 'vat_id', 'status_id', 'stock', 'capacity'], 'default', 'value' => null],
            [['partner_id', 'category_id', 'denomination_id', 'vat_id', 'status_id', 'stock', 'capacity'], 'integer'],
            [['price'], 'number'],
            [['review'], 'string'],
            [['created_at'], 'safe'],
            [['name_id', 'title'], 'string', 'max' => 50],
            [['description', 'degrees', 'variety', 'pairing', 'image'], 'string', 'max' => 255],
            [['name_id'], 'unique'],
            [['name_id'], 'trim'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'id']],
            [['denomination_id'], 'exist', 'skipOnError' => true, 'targetClass' => Denominations::class, 'targetAttribute' => ['denomination_id' => 'id']],
            [['partner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Partners::class, 'targetAttribute' => ['partner_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
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
            'name_id' => Yii::t('app', 'Identificador del artículo'),
            'title' => Yii::t('app', 'Nombre'),
            'description' => Yii::t('app', 'Descripción'),
            'price' => Yii::t('app', 'Precio'),
            'stock' => Yii::t('app', 'Stock'),
            'degrees' => Yii::t('app', 'Graduación alcohólica'),
            'capacity' => Yii::t('app', 'Capacidad'),
            'variety' => Yii::t('app', 'Variedad'),
            'pairing' => Yii::t('app', 'Maridaje'),
            'review' => Yii::t('app', 'Opinión del vendedor'),
            'image' => Yii::t('app', 'Imagen'),
            'upload' => Yii::t('app', 'Subir imagen del artículo'),
            'status_id' => Yii::t('app', 'Estado del artículo'),
            'created_at' => Yii::t('app', 'Creado el'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->uploadImage();

        return true;
    }

    /**
     * Sube la imagen de artículo a Amazon Web Services S3.
     */
    public function uploadImage()
    {
        $this->upload = UploadedFile::getInstance($this, 'upload');
        if ($this->upload !== null) {
            $this->image = AmazonS3::upload($this->upload, $this->name_id, AmazonS3::BUCKET_ARTICLES, $this->image);
            $this->upload = null;
        }
    }

    /**
     * Genera un enlace a la imagen del artículo actual.
     *
     * @param   string    $link   enlace a imagen de perfil.
     */
    public function setLink($link)
    {
        $this->_link = $link;
    }

    /**
     * Genera un enlace a la imagen del artículo actual.
     *
     * @return  string  enlace a imagen de perfil.
     */
    public function getLink()
    {
        if ($this->_link === null && !$this->isNewRecord) {
            $this->setLink(AmazonS3::getLink($this->image, self::IMAGE, AmazonS3::ARTICLES, AmazonS3::BUCKET_ARTICLES));
        }
        return $this->_link;
    }

    /**
     * Genera el precio del artículo con IVA.
     *
     * @param   string    $amount   precio con IVA.
     */
    public function setAmount($amount)
    {
        $this->_amount = $amount;
    }

    /**
     * Genera el precio del artículo con IVA.
     *
     * @return  string  precio con IVA.
     */
    public function getAmount()
    {
        if ($this->_amount === null && !$this->isNewRecord) {
            $this->setAmount(($this->price * $this->vat->value / 100) + $this->price);
        }
        return $this->_amount;
    }

    /**
     * Estrablece la puntuación total.
     *
     * @param   string    $link   enlace a imagen de perfil.
     * @param mixed $score
     */
    public function setScore($score)
    {
        $this->_score = $score;
    }

    /**
     * Genera la puntuación total.
     *
     * @return  string  puntuación total.
     */
    public function getScore()
    {
        if ($this->_score === null && !$this->isNewRecord) {
            $total = null;
            $length = $this->getReviews()->count();
            foreach ($this->getReviews()->all() as  $value) {
                $total += $value['score'];
            }
            $this->setScore($length != 0 ? round($total / $length, 2) : 0);
        }
        return $this->_score;
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
     * Comprueba si el artículo tiene disponibilidad en stock.
     *
     * @return bool  si hay artículos en stock.
     */
    public function isAvailable()
    {
        return $this->stock != 0;
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

    /**
     * Obtiene consulta para [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id'])->inverseOf('articles');
    }

    /**
     * Obtiene consulta para [[Favorites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Favorites::class, ['article_id' => 'id'])->inverseOf('article');
    }

    /**
     * Obtiene consulta para [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::class, ['article_id' => 'id'])->inverseOf('article');
    }

    /**
     * Obtiene consulta para [[CartItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartItems()
    {
        return $this->hasMany(CartItems::class, ['article_id' => 'id'])->inverseOf('article');
    }

    /**
     * Obtiene consulta para [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItems::class, ['article_id' => 'id'])->inverseOf('article');
    }

    /**
     * Comprueba si el usuario actual es el propietario del artículo.
     *
     * @return bool verdadero si es el propietario del artículo.
     */
    public static function isOwner()
    {
        $model = Partners::find()->where(['user_id' => (int) (User::id())]);
        $id = $model->exists() ? (int) ($model->one()->id) : (int) 0;
        return self::find()->where(['partner_id' => $id])->exists();
    }

    /**
     * Comprueba si el usuario conectado ha dejado una reseña.
     *
     * @return bool  verdadero si ya tiene una reseña en el artículo.
     */
    public static function isReview()
    {
        return !Yii::$app->user->isGuest ? Reviews::find()->where(['user_id' => User::id()])->andWhere(['article_id' => Yii::$app->getRequest()->getQueryParam('id')])->exists() : false;
    }

    /**
     * Genera una lista con las etiquetas de los objetos [[Articles]].
     *
     * @return array    array con las etiquetas de [[Articles]] indexados por id.
     */
    public static function labels()
    {
        return static::find()->select('title')->orderBy('title')->indexBy('id')->column();
    }
}
