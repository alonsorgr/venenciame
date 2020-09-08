<?php

use yii\helpers\Url;
use yii\bootstrap4\Html;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\User */

?>

<div class="user-small">
    <div class="row">
        <div class="col-12 col-sm-auto">
            <div class="mx-auto">
                <div class="col d-flex justify-content-center align-items-center">
                    <div class="user-box">
                        <div class="image-profile">
                            <?= Html::img(Html::encode($model->link), [
                                'alt' => Yii::t('app', 'Imagen de usuario'),
                                'data-action' => 'zoom',
                                'title' => Yii::t('app', 'Imagen de usuario'),
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col d-flex flex-column flex-sm-row justify-content-between">
            <div class="text-center text-sm-left">
                <div class="d-block lead mb-2">
                    <?= Html::a(Html::encode($model->fullname), ['user/view', 'id' => $model->id], [
                        'data-pjax' => 0,
                    ]) ?>
                </div>
                <div class="d-block mb-2">
                    <?= Html::a(Html::encode($model->username), ['user/view', 'id' => $model->id], [
                        'data-pjax' => 0,
                    ]) ?>
                </div>
                <div class="d-block mb-2">
                    <i class="fas fa-envelope mr-1"></i>
                    <?= Yii::$app->formatter->asEmail(Html::encode($model->email)) ?>
                </div>
            </div>
            <div class="text-center text-sm-right">
                <small class="text-muted">
                    <i class="fas fa-calendar icon-sm mr-1"></i>
                    <?= Yii::t('app', 'Registrado el {date}', [
                        'date' => Html::encode(Yii::$app->formatter->asDate($model->created_at)),
                    ]) ?>
                </small>
            </div>
        </div>
    </div>
    <div class="mt-xl-1 horizontal-divider"></div>
</div>