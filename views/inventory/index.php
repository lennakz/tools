<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inventories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventory-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Inventory', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
				'label' => 'Tool',
				'attribute' => 'tool.name',
			],
            [
				'label' => 'Job Site',
				'attribute' => 'jobSite.street',
			],
            [
				'label' => 'Status',
				'attribute' => 'status.status',
			],
			'note:ntext',
			[
				'class' => 'yii\grid\ActionColumn',
				'header' => 'Actions',
			],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
