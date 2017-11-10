<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Job Sites';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-site-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Job Site', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'street',
            'city',
            'province',
            'postal_code',
            // 'complete',
            [
				'class' => 'yii\grid\ActionColumn',
				'header' => 'Actions',
			],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
