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
				['label' => 'Main Menu', 'options' => ['class' => 'header']],
				['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
				['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
				['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
				[
					'label' => 'Some tools',
					'icon' => 'share',
					'url' => '#',
					'items' => [
						['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
						['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
						[
							'label' => 'Level One',
							'icon' => 'circle-o',
							'url' => '#',
							'items' => [
								['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
								[
									'label' => 'Level Two',
									'icon' => 'circle-o',
									'url' => '#',
									'items' => [
										['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
										['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
									],
								],
							],
						],
					],
				],
			],
		]);
	}
}
