<?php

use app\assets\DzAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */

DzAsset::register($this);

$this->registerJs("Dropzone.options.uploadForm = { paramName: 'UploadForm[files][]' };", View::POS_END, 'dropzone');

?>

<?php $form = ActiveForm::begin(['action' => Url::to(['admin/multimedia/upload']), 'id' => 'upload-form', 'options' => ['class' => 'dropzone', 'enctype' => 'multipart/form-data']]) ?>

    <div class="fallback">

    <?= $form->field($model, 'files[]')->fileInput(['multiple' => true, 'accept' => 'audio/*,video/*,image/*,application/*']) ?>

    <button>Submit</button>

    </div>

<?php ActiveForm::end() ?>

<div class="row gallery">

<?php foreach ($multimedia as $media): ?>

    <div class="col-md-2 col-xs-4">
        <div class="gallery-item hovereffect">
            <img class="img-responsive center-block" alt="" src="<?= $media->url ?>" />
            <div class="overlay">
                <h2><?= $media->type ?></h2>
                <p class="icon-links">
                    <?= Html::a('<span class="fa fa-close text-danger"></span>', ['admin/multimedia/delete', 'id' => $media->id], [
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this ' . $media->type . '?',
                            'method' => 'post',
                        ]
                    ]) ?>
                    <?= Html::a('<span class="fa fa-pencil"></span>', ['admin/multimedia/view', 'id' => $media->id]) ?>
                </p>
            </div>
        </div>
    </div>

<?php endforeach; ?>

</div>