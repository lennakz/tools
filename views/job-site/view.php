<?php

use yii\helpers\Html;

use yii\widgets\Pjax;

use yii\grid\GridView;
use yii\grid\CheckboxColumn;

/* @var $this yii\web\View */
/* @var $model app\models\JobSite */

$this->title = $model->street;
$this->params['breadcrumbs'][] = ['label' => 'Job Sites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="job-site-view">

    <h1>
		<?= Html::encode($this->title) ?>
		<span class="update">
			<?= Html::a('Update', ['update', 'id' => $model->id]) ?>
		</span>
		<span class="delete">
			<?=
			Html::a('Delete', ['delete', 'id' => $model->id], [
				'data' => [
					'confirm' => 'Are you sure you want to delete this item?',
					'method' => 'post',
				],
			])

			?>
		</span>
	</h1>

	<div class="jobsite-short-info">
		<h4>Details:</h4>
		<?php if (!empty($model->name)): ?>
			<p><strong>Name:</strong> <?= $model->name ?></p>
		<?php endif; ?>
		<p><strong>Type:</strong> <?= $model->typeText ?></p>
		<p><strong>Address:</strong> <?= $model->fullAddress ?></p>
		<p><strong>Status:</strong> <?= $model->completeText ?></p>
		<p><strong>Total Inventories:</strong> <?= $dataProvider->totalCount ?></p>
		<?php ?>
	</div>
	
	<?php Pjax::begin([
		'id' => 'pjax-gridview-jobsite-view',
		'timeout' => 10000,
	]); ?>    
		
		<?=	GridView::widget([
			'dataProvider' => $dataProvider,
			'columns' => [
				[
					'label' => 'Inventory #',
					'attribute' => 'formattedNumber',
				],
				[
					'label' => 'Tool',
					'attribute' => 'tool.name',
				],
				[
					'label' => 'Category',
					'attribute' => 'category.name',
				],
				[
					'label' => 'Status',
					'attribute' => 'statusText',
				],
				[
					'class' => 'yii\grid\ActionColumn',
					'controller' => 'inventory',
					'header' => 'Actions',
				],
				['class' => CheckboxColumn::className()],
			],
			'summary' => '<p class="text-center">Showing {begin}-{end} out of total {totalCount} records</p>',
			]); ?>
	<?php Pjax::end(); ?>

</div>
