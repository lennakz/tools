<?php

use yii\helpers\Html;
use yii\helpers\Url;

use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use yii\widgets\Pjax;

use dosamigos\typeahead\TypeAhead;
use dosamigos\typeahead\Bloodhound;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inventories';

$template = 
	'<div class="search-result-inventories"><a href="{{url}}">{{name}} (#{{inventory_number}}) - {{job_site}} - {{status}}</a></div>';

$engine = new Bloodhound([
	'name' => 'inventoryEngine',
	'clientOptions' => [
		'datumTokenizer' => new JsExpression("Bloodhound.tokenizers.obj.whitespace('name')"),
		'queryTokenizer' => new JsExpression("Bloodhound.tokenizers.whitespace"),
		'prefetch' => [
			'url' => Url::to(['inventory/inventories_json']),
			'ttl' => 3600000, // 1 hour
		]
	]
]);

?>
<div class="inventory-index">

    <h1>
		<?= Html::encode($this->title) ?>
		<span class="create-new"><?= Html::a('Create new', ['create']) ?></span>
	</h1>
		
	<br>
	
	<div>
		<?= TypeAhead::widget([
			'name' => 'inventories', 
			'options' => ['placeholder' => 'Search for inventories ...', 'class' => 'form-control'],
			'engines' => [ $engine ],
			'clientOptions' => [
				'highlight' => true,
				'minLength' => 2				
			],
			'dataSets' => [
				[
					'name' => 'typeahead-form',
					'source' => $engine->getAdapterScript(),
					'displayKey' => 'name',
					'templates' => [
						'notFound' => '<div class="search-result-inventories not-found">Unable to find this inventory</div>',
						'suggestion' => new JsExpression("Handlebars.compile('{$template}')"),
					],
				],
			],			
		]); 
		?>
	</div>
	<br><br>
	
	<div class="filter-buttons">
		<?= Html::a('Show All', ['index'], ['class' => 'btn btn-default refresh-table']); ?>
		<?php foreach ($filter_buttons_array as $cat_name => $cats): ?>
			<div class="dropdown">
				<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><?= $cat_name ?><span class="caret"></span></button>
				<ul class="dropdown-menu">
					<?php foreach ($cats as $id => $cat): ?>
						<li><a href="<?= $cat['url'] ?>" class="refresh-table"><?= $cat['name'] ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endforeach; ?>
	</div>
	
	<?php Pjax::begin([
		'id' => 'pjax-gridview',
		'linkSelector' => '#pjax-gridview a, .refresh-table',
		'timeout' => 10000,
	]); ?>    
		<h3 class="filter-header text-center">Showing <?= $filter_header ?>: <?= $filter_header_link ?></h3>
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
					['class' => CheckboxColumn::className()],
				],
				'summary' => '<p class="text-center">Showing {begin}-{end} out of total {totalCount} records</p>',
			]);
		?>
	<?php Pjax::end(); ?>
		
</div>
