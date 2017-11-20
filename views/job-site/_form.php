<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\JobSite;

/* @var $this yii\web\View */
/* @var $model app\models\JobSite */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="job-site-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'type')->dropDownList(JobSite::getTypeArray(), ['prompt' => 'Select type', 'value' => 1]) ?>
	
    <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'province')->dropDownList(JobSite::getProvincesArray(), ['prompt' => 'Select province', 'value' => 'BC']) ?>

    <?= $form->field($model, 'complete')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
