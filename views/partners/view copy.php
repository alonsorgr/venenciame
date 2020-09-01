<?php

use yii\helpers\Url;
use yii\bootstrap4\Html;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Partners */

$follow = Url::to(['followers/follow', 'user_id' => User::id(), 'partner_id' => $model->id]);

$js = <<<EOT
$(document).ready(function(){
    $('#partner-follow').css('cursor', 'pointer');
    $.ajax({
        type : 'GET',
        url : '$follow',
        success: function(response) {
            response = JSON.parse(response);
            $('#partner-follow').removeClass('far');
            $('#partner-follow').addClass(response.class);
            $('#partner-follow').prop('title', response.title);
        }
    });
    $('#partner-follow').click(function(e){
        e.preventDefault();
        $.ajax({
            type : 'POST',
            url : '$follow',
            success: function(response) {
                response = JSON.parse(response);
                $('#partner-follow').removeClass('fas');
                $('#partner-follow').addClass(response.class);
                $('#partner-follow').prop('title', response.title);
            }
        });
    });
});
EOT;

$this->registerJs($js);

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Socios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="partners-view">
    <div class="row justify-content-between">
        <div class="col-xl-8 mt-5">
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
                        <div class="d-block mb-xl-2 display-6">
                            <?= Html::encode($model->name) ?>
                        </div>
                        <div class="d-block text-break my-4 lead-sm font-italic mr-sm-4">
                            <?= Html::encode($model->description) ?>
                        </div>
                    </div>
                    <div class="text-center text-nowrap text-sm-right">
                        <small class="text-muted">
                            <i class="fas fa-calendar icon-sm mr-1"></i>
                            <?= Yii::t('app', 'Registrado el {date}', [
                                'date' => Html::encode(Yii::$app->formatter->asDate($model->created_at)),
                            ]) ?>
                        </small>
                        <div class="d-block justify-content-end mt-3">
                            <?= Html::a(null, null, [
                                'id' => 'partner-follow',
                                'class' => 'far fa-heart no-underline heart-size text-danger',
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-xl-3 horizontal-divider"></div>

        </div>
        <div class="col-xl-3">
            <?= $this->render('_sidebar'); ?>
        </div>
    </div>

</div>