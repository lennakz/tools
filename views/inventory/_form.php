<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Inventory */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="inventory-form">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'tool_id')->dropDownList($model->getAllToolsArray(), ['prompt' => 'Select Tool'])->label('Tool') ?>

		<div class="form-group">
			<?= Html::a('Add New Tool', Url::to(['tool/create'])) ?>
		</div>	

		<?= $form->field($model, 'job_site_id')->dropDownList($model->getAllJobSitesArray(), ['prompt' => 'Select Job Site'])->label('Job Site') ?>

		<div class="form-group">
			<?= Html::a('Add New Job Site', Url::to(['job-site/create'])) ?>
		</div>	

		<?= $form->field($model, 'status_id')->dropDownList($model->getAllStatusesArray(), ['prompt' => 'Select Status', 'value' => 1])->label('Status') ?>
	
		<?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

		<?= $form->field($model, 'serial_number')->textInput(['maxlength' => true]) ?>

		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
