<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Categories;

/* @var $this yii\web\View */
?>

<div class="row">

	<div class="col-md-8">
		<div class="focal-point">
			<div id="grid-source"><img src="<?= $model->url ?>" class="img-responsive" alt=""></div>
		</div>
	</div>

	<div class="col-md-4">
		<?php 

			$form = ActiveForm::begin();

			echo Html::activeHiddenInput($model, 'row');
			echo Html::activeHiddenInput($model, 'column');

			echo $form->field($model, 'description');

			echo $form->field($model, 'credits');

			echo $form->field($model, 'category_id')->dropdownList(
				Categories::find()->select(['description', 'id'])->indexBy('id')->column(),
				['prompt'=>'Select Category']
			);

		?>

		<div class="form-group">
	        <div class="col-lg-offset-1 col-lg-11">
	            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
	        </div>
	    </div>

	</div>

</div>