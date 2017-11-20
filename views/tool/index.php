<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tools';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tool-index">

    <h1>
		<?= Html::encode($this->title) ?>
		<span class="create-new"><?= Html::a('Create new', ['create']) ?></span>
	</h1>

    <div>

	</div>
	
	
	<?php Pjax::begin(); ?>    
		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'columns' => [
				'name',
				[
					'label' => 'Make',
					'attribute' => 'make.name',
				],
				[
					'label' => 'Category',
					'attribute' => 'category.name',
				],
				'model',
				[
					'class' => 'yii\grid\ActionColumn',
					'header' => 'Actions',
				],
			],
		]); ?>
	<?php Pjax::end(); ?>
</div>
