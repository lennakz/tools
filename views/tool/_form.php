<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use dosamigos\select2\Select2Bootstrap;

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
	
	<?= $form->field($model, 'make')->label('Make')->widget(
			Select2Bootstrap::class, 
				[
					'items' => $model->getAllMakesArray(), // $data should be the same as the items provided to a regular yii2 dropdownlist
					'clientOptions' => [
						'placeholder' => 'Type or select make',
						'width' => '100%',
						'allowClear' => true,
					],
				]
			);
		?>
	
	<div class="form-group">
		<?= Html::a('Create new Make', Url::to(['make/create'])) ?>
	</div>
		
    <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
