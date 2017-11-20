<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

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
				'attribute' => 'status.status',
			],
			'note:ntext',
        ],
    ]) ?>
	
	<div>History come here</div>

</div>
