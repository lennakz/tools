<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Tool */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tool-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'category_id')->dropDownList($model->getAllCategoriesArray(), ['prompt' => 'Select Category'])->label('Category') ?>
	
	<div class="form-group">
		<?= Html::a('Add New Category', Url::to(['tool/createCategory'])) ?>
	</div>	
		
    <?= $form->field($model, 'make')->dropDownList($model->getAllMakesArray(), ['prompt' => 'Select Make']) ?>
	
	<div class="form-group">
		<?= Html::a('Create new Make', Url::to(['make/create'])) ?>
	</div>
		
    <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
