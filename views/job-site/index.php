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

    <h1>
		<?= Html::encode($this->title) ?>
		<span class="create-new"><?= Html::a('Create new', ['create']) ?></span>
	</h1>

	<?= $this->context->renderJobSiteButtons() ?>
	
	<br>
	<div id="map"></div>
	<br>
	
	<?php Pjax::begin([
		'id' => 'pjax-gridview-jobsites',
		'timeout' => 10000,
	]); ?>    
		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'columns' => [
				[
					'label' => 'Status',
					'attribute' => 'completeText',
				],
				[
					'label' => 'Street',
					'attribute' => 'street',
					'format' => 'raw',
					'value' => function ($model) {
						return Html::a($model->street, $model->url);
					},
				],
				'city',
				'province',
				'postal_code',
				[
					'label' => 'Type',
					'attribute' => 'typeText',
				],
				[
					'label' => 'Total',
					'attribute' => 'totalInventories',
				],
				[
					'class' => 'yii\grid\ActionColumn',
					'header' => 'Actions',
				],
			],
		]); ?>
	<?php Pjax::end(); ?>
</div>

<script>
	var job_sites = <?= $googlemap_json ?>;
	
	function initMap() {
		var west_vancouver = {lat: 49.3349, lng: -123.1668};
		var map = new google.maps.Map(document.getElementById('map'), {
			center: west_vancouver,
			zoom: 12
		});
		
		// js = Job Sites
		var jsMarkers = [];
		var jsInfoWindows = [];
		
		for (let i = 0; i < job_sites.length; i++) {
			var js = job_sites[i];
			var latLng = new google.maps.LatLng(js.lat, js.lng);
			
			jsMarkers[i] = new google.maps.Marker({
				position: latLng,
				map: map,
				icon: js.icon_url
			});
			jsInfoWindows[i] = new google.maps.InfoWindow({
				content: 
						'<div class="jobsite-infowindow">' +
							'<p><strong>Name: </strong><a href="' + js.url + '">' + js.name + '</a></p>' +
							'<p><strong>Type: </strong>' + js.type + '</p>' +
							'<p><strong>Total: </strong>' + js.total_inventories + '</p>' +
						'</div>'
			});
			jsMarkers[i].addListener('click', function() {
				jsInfoWindows.forEach(function(element) { element.close(); });
				jsInfoWindows[i].open(map, this);
			});
		}
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?= app()->params['googlemap_api_key'] ?>&callback=initMap" async defer></script>