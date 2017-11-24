<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\grid\GridView;
use app\models\InventoryLog;

/* @var $this yii\web\View */
/* @var $model app\models\Inventory */

$this->title = $model->tool->name;
$this->params['breadcrumbs'][] = ['label' => 'Inventories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventory-view">

    <h1>
		<?= Html::encode($this->title) ?> (#<?= Html::encode($model->formattedNumber) ?>)
		<span class="update">
			<?= Html::a('Update', ['update', 'id' => $model->id]) ?>
		</span>
		<span class="delete">
			<?= Html::a('Delete', ['delete', 'id' => $model->id], [
				'data' => [
					'confirm' => 'Are you sure you want to delete this item?',
					'method' => 'post',
				],
			]) ?>
		</span>
	</h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
				'label' => 'Inventory Number',
				'attribute' => 'formattedNumber',
			],
            [
				'label' => 'Tool',
				'attribute' => 'tool.name',
			],
            'serial_number',
            [
				'label' => 'Job Site',
				'attribute' => 'jobSite.street',
			],
            [
				'label' => 'Status',
				'attribute' => 'statusText',
			],
			'note:ntext',
        ],
    ]) ?>
	
	<h3>Change History</h3>
	
	<?php Pjax::begin([
		'id' => 'pjax-gridview-logs',
		'timeout' => 5000,
	]); ?>    
		<?=	GridView::widget([
			'dataProvider' => $logs_data_provider,
			'columns' => [
				[
					'label' => 'Change Date',
					'attribute' => 'change_date',
					'format' => 'datetime',
				],
				[
					'label' => 'Inventory #',
					'value' => function($model, $key, $index, $column) {
						if ($model->isChanged('inventory_number'))
							return $model->getChangedText(InventoryLog::findOne($model->previous_id)->formattedNumber, $model->formattedNumber);
						else
							return $model->formattedNumber;
					},
					'format' => 'raw',
				],
				[
					'label' => 'Tool',
					'value' => function($model, $key, $index, $column) {
						if ($model->isChanged('tool_id'))
							return $model->getChangedText(InventoryLog::findOne($model->previous_id)->tool->name, $model->tool->name);
						else
							return $model->tool->name;							
					},
					'format' => 'raw',
				],
				[
					'label' => 'Job Site',
					'value' => function($model, $key, $index, $column) {
						if ($model->isChanged('job_site_id'))
							return $model->getChangedText(InventoryLog::findOne($model->previous_id)->jobSite->name, $model->jobSite->name);
						else
							return $model->jobSite->name;							
					},
					'format' => 'raw',
				],
				[
					'label' => 'Status',
					'value' => function($model, $key, $index, $column) {
						if ($model->isChanged('status_id'))
							return $model->getChangedText(InventoryLog::findOne($model->previous_id)->statusText, $model->statusText);
						else
							return $model->statusText;
					},
					'format' => 'raw',
				],
						[
					'label' => 'Note',
					'value' => function($model, $key, $index, $column) {
						if ($model->isChanged('note'))
							return $model->getChangedText(InventoryLog::findOne($model->previous_id)->note, $model->note);
						else
							return $model->note;	
					},
					'format' => 'raw',
				],
				[
					'label' => 'S/N',
					'value' => function($model, $key, $index, $column) {
						if ($model->isChanged('serial_number'))
							return $model->getChangedText(InventoryLog::findOne($model->previous_id)->serial_number, $model->serial_number);
						else
							return $model->serial_number;
					},
					'format' => 'raw',
				],
			],
			'summary' => '<p class="text-center">Showing {begin}-{end} out of total {totalCount} records</p>',
		]); ?>
	<?php Pjax::end(); ?>

</div>
