<?php

use yii\helpers\Html;
use yii\helpers\Url;

use yii\grid\GridView;
use yii\widgets\Pjax;

use app\models\ToolCategory;
use app\models\InventoryStatus;
use app\models\JobSite;

use dosamigos\typeahead\TypeAhead;
use dosamigos\typeahead\Bloodhound;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inventories';

?>
<div class="inventory-index">

    <h1><?= Html::encode($this->title) ?></h1>
	
	<div>
		<form>
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search">
				<div class="input-group-btn">
					<button class="btn btn-default" type="submit">
						<i class="glyphicon glyphicon-search"></i>
					</button>
					<?= Html::a('Create new', ['create'], ['class' => 'btn btn-default']); ?>
				</div>
			</div>
		</form>
	</div>
	<br><br><br>
	
	<div class="filter-buttons">
		<?= Html::a('Show All', ['index'], ['class' => 'btn btn-default']); ?>
		<div class="dropdown">
			<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Categories<span class="caret"></span></button>
			<ul class="dropdown-menu">
				<?php foreach (ToolCategory::find()->all() as $cat): ?>
					<li><a href="<?= Url::toRoute(['index', 'cat' => $cat->id]) ?>" class="refresh-table"><?= $cat->name ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="dropdown">
			<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Status<span class="caret"></span></button>
			<ul class="dropdown-menu">
				<?php foreach (InventoryStatus::find()->all() as $status): ?>
					<li><a href="<?= Url::toRoute(['index', 'status' => $status->id]) ?>" class="refresh-table"><?= $status->status ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="dropdown">
			<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Job Sites<span class="caret"></span></button>
			<ul class="dropdown-menu">
				<?php foreach (JobSite::find()->all() as $job_site): ?>
					<li><a href="<?= Url::toRoute(['index', 'job_site' => $job_site->id]) ?>" class="refresh-table"><?= $job_site->street ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	
	<?php Pjax::begin([
		'linkSelector' => '.refresh-table',
	]); ?>    
		<?=	GridView::widget([
				'dataProvider' => $dataProvider,
				'columns' => [
					'id',
					[
						'label' => 'Tool',
						'attribute' => 'tool.name',
					],
					[
						'label' => 'Category',
						'attribute' => 'tool.category.name',
					],
					[
						'label' => 'Job Site',
						'attribute' => 'jobSite.street',
					],
					[
						'label' => 'Status',
						'attribute' => 'status.status',
					],
					[
						'class' => 'yii\grid\ActionColumn',
						'header' => 'Actions',
					],
				],
			]);
		?>
	<?php Pjax::end(); ?>
	
</div>
