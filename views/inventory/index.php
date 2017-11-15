<?php

use yii\helpers\Html;
use yii\helpers\Url;

use yii\grid\GridView;
use yii\widgets\Pjax;

use dosamigos\typeahead\TypeAhead;
use dosamigos\typeahead\Bloodhound;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inventories';

$engine = new Bloodhound([
	'name' => 'inventoriesEngine',
	'clientOptions' => [
		'datumTokenizer' => new \yii\web\JsExpression("Bloodhound.tokenizers.obj.whitespace('name')"),
		'queryTokenizer' => new \yii\web\JsExpression("Bloodhound.tokenizers.whitespace"),
		'remote' => [
			'url' => Url::to(['inventoriesJson', 'query'=>'QRY']),
			'wildcard' => 'QRY'
		]
	]
]);

?>
<div class="inventory-index">

    <h1><?= Html::encode($this->title) ?></h1>
	
	<div>
		<form>
			<div class="typeahead__container">
				<div class="typeahead__field">

					<span class="typeahead__query">
						<input class="js-typeahead"
							   name="q"
							   type="search"
							   autocomplete="off"
							   placeholder="Search for name...">
					</span>
					<span class="typeahead__button">
						<button type="submit">
							<span class="typeahead__search-icon"></span>
						</button>
					</span>

				</div>
			</div>
		</form>
		<form>
			<div class="input-group" id="bloodhound">
				<input type="text" class="typeahead form-control" placeholder="Search">
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
				],
				'summary' => '<p class="text-center">Showing {begin}-{end} out of total {totalCount} records</p>',
			]);
		?>
	<?php Pjax::end(); ?>
	
</div>

<script>
	$(function() {
		var clients = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			limit: 10,
			prefetch: {
				ttl: 1000, 
				url: 'inventory/json'
			}
		});
		
		clients.initialize();
		
		$('.js-typeahead').typeahead(null, {
			name: 'clients',
			displayKey: 'html',
			source: clients.ttAdapter(),
			templates: {
				suggestion: function(obj) {
					var html =
						'<div class="container">' +
							'<div class="row suggestion-box">' +
									'<span class="player-name">' + obj.name + '</span>' +
									
								'</a>' +
							'</div>' +
						'</div>';
					
					return html;
				}
			}
		});
	});
</script>