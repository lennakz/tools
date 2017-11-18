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
	'<div>'
	. '<p class="">{{name}}</p>' .
		'<p class="repo-name">{{job_site}}</p>' .
		'<p class="repo-description">{{status}}</p>'
	. '</div>';

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

    <h1><?= Html::encode($this->title) ?></h1>
	
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
						'notFound' => '<div>Unable to find repositories for selected query.</div',
						'suggestion' => new JsExpression("Handlebars.compile('{$template}')"),
					],
				],
			],			
		]); 
		?>
	</div>
	<br><br><br>
	
	<?= Html::a('Create new', ['create'], ['class' => 'btn btn-default']); ?>
	
	<div class="filter-buttons">
		<?= Html::a('Show All', ['index'], ['class' => 'btn btn-default']); ?>
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
		<h3 class="filter-header text-center">Showing <?= $filter_header ?></h3>
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
