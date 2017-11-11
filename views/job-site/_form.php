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

    <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'province')->dropDownList(JobSite::getProvincesArray(), ['prompt' => 'Select Province', 'value' => 'BC']) ?>

    <?= $form->field($model, 'postal_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'complete')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
