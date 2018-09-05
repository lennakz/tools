<?php

namespace app\components;

use Yii;
use yii\web\View as ViewWeb;
use app\components\widgets\Menu;


class View extends ViewWeb
{
	public $bodyClass = 'hold-transition skin-blue sidebar-mini';
	public $pageHeader = '';
	public $pageSubheader = '';
	
	
	public function getSidebarMenu()
	{
		return Menu::widget([
			'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
			'items' => [
				[
					'label' => 'Inventory',
					'icon' => 'file-text-o',
					'url' => '#',
					'items' => [
						['label' => 'Create', 'icon' => 'plus', 'url' => ['/job-site/create'],],
						['label' => 'View', 'icon' => 'eye', 'url' => ['/inventory/index'],],						
					],
				],
				[
					'label' => 'Job Sites',
					'icon' => 'home',
					'url' => '#',
					'items' => [
						['label' => 'Create', 'icon' => 'plus', 'url' => ['/job-site/create'],],
						['label' => 'View', 'icon' => 'eye', 'url' => ['/job-site/index'],],						
					],
				],
				[
					'label' => 'Tools',
					'icon' => 'hand-lizard-o',
					'url' => '#',
					'items' => [
						['label' => 'Create', 'icon' => 'plus', 'url' => ['/tool/create'],],
						['label' => 'View', 'icon' => 'eye', 'url' => ['/tool/index'],],						
					],
				],
				[
					'label' => 'Order',
					'icon' => 'file-text',
					'url' => '#',
					'items' => [
						['label' => 'Create', 'icon' => 'plus', 'url' => ['/order/create'],],
						['label' => 'View', 'icon' => 'eye', 'url' => ['/order/index'],],						
					],
				],
			],
		]);
	}
}
