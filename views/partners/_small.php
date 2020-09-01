<?php

use yii\helpers\Url;
use yii\bootstrap4\Html;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Partners */

$follow = Url::to(['followers/follow', 'user_id' => User::id(), 'partner_id' => $model->id]);
$id = $model->id;

$js = <<<EOT
$(document).ready(function(){
    $('#partner-follow-' + $id).css('cursor', 'pointer');
    $.ajax({
        type : 'GET',
        url : '$follow',
        success: function(response) {
            response = JSON.parse(response);
            $('#partner-follow-' + $id).removeClass('far');
            $('#partner-follow-' + $id).addClass(response.class);
            $('#partner-follow-' + $id).prop('title', response.title);
        }
    });
    $('#partner-follow-' + $id).click(function(e){
        e.preventDefault();
        $.ajax({
            type : 'POST',
            url : '$follow',
            success: function(response) {
                response = JSON.parse(response);
                $('#partner-follow-' + $id).removeClass('fas');
                $('#partner-follow-' + $id).addClass(response.class);
                $('#partner-follow-' + $id).prop('title', response.title);
                $.pjax.reload({ container: '#partners-followed-pjax', timeout: false });
            }
        });
    });
});
EOT;

$this->registerJs($js);
?>

<div class="partner-small">
    <div class="row">
        <div class="col-12 col-sm-auto mt-4">
            <div class="mx-auto">
                <div class="col d-flex justify-content-center align-items-center">
                    <div class="user-box">
                        <div class="image-profile">
                            <?= Html::img(Html::encode($model->link), [
                                'alt' => Yii::t('app', 'Logo corporativo'),
                                'title' => Yii::t('app', 'Logo corporativo'),
                                'data-action' => 'zoom',
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col d-flex flex-column flex-sm-row justify-content-between mt-4">
            <div class="text-center text-sm-left">
                <div class="d-block mb-xl-2 mt-2 lead">
                    <?= Html::a(Html::encode($model->name), ['partners/view', 'id' => $model->id], [
                        'data-pjax' => 0,
                    ]) ?>
                </div>
                <cite class="d-block text-break font-italic mr-lg-5 mt-2">
                    <?= Html::encode($model->description) ?>
                </cite>
            </div>
            <div class="text-center text-nowrap text-sm-right mt-3">
                <small class="text-muted">
                    <?= Yii::t('app', 'Registrado el {date}', [
                        'date' => Html::encode(Yii::$app->formatter->asDate($model->created_at)),
                    ]) ?>
                    <i class="fas fa-calendar icon-sm ml-2"></i>
                </small>
                <div class="d-block mt-2 text-muted">
                    <?= Yii::$app->formatter->asUrl($model->url) ?>
                    <i class="fas fa-link icon-sm ml-2"></i>
                </div>
                <div class="d-block mt-2 text-muted">
                    <?= Yii::$app->formatter->asEmail($model->email) ?>
                    <i class="fas fa-envelope icon-sm ml-2"></i>
                </div>
                <div class="d-block mt-2 text-muted">
                    <?= Html::encode($model->location) ?>
                </div>
                <div class="d-block justify-content-end mt-3">
                    <?= Html::a(null, null, [
                        'id' => 'partner-follow-' . $id,
                        'class' => 'far fa-heart no-underline heart-size text-danger',
                        'data-pjax' => 0,
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="my-xl-3 horizontal-divider"></div>
</div>