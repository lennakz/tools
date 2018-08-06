<?php

namespace app\components;

use yii\web\Controller;
use app\assets\AdminLteAsset;


class BaseController extends Controller
{
	public $layout = 'sidebars';


	public function init()
	{
		parent::init();
		
		AdminLteAsset::register($this->view);
	}
	
}
