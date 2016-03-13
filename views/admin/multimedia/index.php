<?php

use app\assets\DzAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */

//DzAsset::register($this);

//$this->registerJs("Dropzone.options.uploadForm = { paramName: 'files[]' };", View::POS_END, 'dropzone');

?>

<?php $form = ActiveForm::begin(['action' => Url::to(['admin/multimedia/upload']), 'id' => 'upload-form', 'options' => ['class' => 'dropzone', 'enctype' => 'multipart/form-data']]) ?>

    <div class="fallback">

    <?= $form->field($model, 'files[]')->fileInput(['multiple' => true, 'accept' => 'audio/*,video/*,image/*,application/*']) ?>

    <button>Submit</button>

    </div>

<?php ActiveForm::end() ?>

<div class="row gallery">
	<div class="col-md-3">
        <div class="well image">
            <img class="thumbnail img-responsive" alt="" src="http://www.prepbootstrap.com/Content/images/shared/houses/h9.jpg" />
        </div>
    </div>
    <div class="col-md-3">
        <div class="well video">
            <img class="thumbnail img-responsive" alt="" src="http://www.prepbootstrap.com/Content/images/shared/houses/h8.jpg" />
        </div>
    </div>
    <div class="col-md-3">
        <div class="well audio">
            <img class="thumbnail img-responsive" alt="" src="http://www.prepbootstrap.com/Content/images/shared/houses/h4.jpg" />
        </div>
    </div>
</div>