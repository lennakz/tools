<?php

namespace app\controllers;

use Yii;
use app\models\JobSite;
use app\models\Inventory;
use yii\data\ActiveDataProvider;

use app\components\BaseController;

use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

use app\components\ControllerTrait;

/**
 * JobSiteController implements the CRUD actions for JobSite model.
 */
class JobSiteController extends BaseController
{
	use ControllerTrait;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}

	/**
	 * Lists all JobSite models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$query = JobSite::find();
				
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
				'attributes' => [
					'street',
					'city',
					'province',
					'postal_code',
					'completeText' => [
						'asc' => ['complete' => SORT_ASC],
						'desc' => ['complete' => SORT_DESC],
					],
					'typeText' => [
						'asc' => ['type_id' => SORT_ASC],
						'desc' => ['type_id' => SORT_DESC],
					],
				],
				'defaultOrder' => [
					'completeText' => SORT_ASC,
				],
			],
		]);
		
		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'googlemap_json' => $this->getGoogleMapCoordJson(),
		]);
	}
	
	public function getGoogleMapCoordJson()
	{
		$array = [];
		$models = JobSite::find()->all();
		$lookup_markers = JobSite::getLookupMarkersArray();
		
		foreach ($models as $m)
		{
			$array[] = [
				'name' => $m->name,
				'lat' => $m->lat,
				'lng' => $m->lng,
				'url' => Url::to(['job-site/view', 'id' => $m->id]),
				'total_inventories' => $m->totalInventories,
				'type' => $m->typeText,
				'icon_url' => $lookup_markers[$m->type_id],
			];
		}
		
		return Json::encode($array);
	}
	
	/**
	 * Displays a single JobSite model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$query = Inventory::find()->joinWith(['tool', 'jobSite', 'category'])->where(['job_site_id' => $id]);
		$pagination = ['pageSize' => 50,];
		
		$dataProvider = $this->getInventoryDataProvider($query, $pagination);
		$model = $this->findModel($id);
		
		return $this->render('view', [
			'model' => $model,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Creates a new JobSite model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new JobSite();

		if ($model->load(Yii::$app->request->post()) && $model->save())
		{
			return $this->redirect(['index']);
		}
		else
		{
			return $this->render('create', [
					'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing JobSite model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save())
		{
			return $this->redirect(['index']);
		}
		else
		{
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Deletes an existing JobSite model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}
	
	public function renderJobSiteButtons()
	{
		$buttons = '<div class="jobsite-buttons">';
		foreach (JobSite::find()->all() as $m)
			$buttons .= Html::a($m->nameText, ['job-site/view', 'id' => $m->id], ['class' => 'btn btn-default']);
		
		$buttons .= '</div>';
		
		return $buttons;
	}

	/**
	 * Finds the JobSite model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return JobSite the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = JobSite::findOne($id)) !== null)
		{
			return $model;
		}
		else
		{
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
	

}
