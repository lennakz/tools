<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\helpers\Html;

use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Inventory;
use app\models\Tool;
use app\models\ToolCategory;
use app\models\InventoryStatus;
use app\models\JobSite;

use app\components\ControllerTrait;

/**
 * InventoryController implements the CRUD actions for Inventory model.
 */
class InventoryController extends Controller
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
                    'delete' => ['post'],
					'logout' => ['post'],
                ],
            ],
			'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

	/**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

	/**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
		$this->view->title = 'About';
		$this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('about.tpl');
    }

    /**
     * Lists all Inventory models.
     * @return mixed
     */
    public function actionIndex()
    {
		$filter_header = '';
		$filter_header_link = '';
		$filter_buttons_array = $this->getFilterButtonsArray();
		$param = app()->request->get();
		
		$query = Inventory::find()->joinWith(['tool', 'jobSite', 'status', 'category']);
		$filter_header = 'All';

		if (!empty($param['cat']))
		{
			$query = $query->where(['tools.category_id' => $param['cat']]);
			$filter_header = 'Categories';
			$filter_header_link = $filter_buttons_array['Categories'][$param['cat']]['link'];
		}
		elseif (!empty($param['status']))
		{
			$query = $query->where(['status_id' => $param['status']]);
			$filter_header = 'Statuses';
			$filter_header_link = $filter_buttons_array['Status'][$param['status']]['link'];
		}
		elseif (!empty($param['job_site']))
		{
			$query = $query->where(['job_site_id' => $param['job_site']]);
			$filter_header = 'Job Sites';
			$filter_header_link = $filter_buttons_array['Job Sites'][$param['job_site']]['link'];			
		}

		$dataProvider = $this->getInventoryDataProvider($query);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
			'filter_header' => $filter_header,
			'filter_header_link' => $filter_header_link,
			'filter_buttons_array' => $filter_buttons_array,
		]);
    }

	public function getFilterButtonsArray()
	{
		$array = [];

		foreach (ToolCategory::find()->all() as $cat)
			$array['Categories'][$cat->id] = [
				'link' => Html::a($cat->name, ['category/view', 'id' => $cat->id]),
				'name' => $cat->name,
				'url' => Url::toRoute(['index', 'cat' => $cat->id]),
			];

		foreach (InventoryStatus::find()->all() as $status)
			$array['Status'][$status->id] = [
				'link' => $status->status,
				'name' => $status->status,
				'url' => Url::toRoute(['index', 'status' => $status->id]),
			];

		foreach (JobSite::find()->all() as $job_site)
			$array['Job Sites'][$job_site->id] = [
				'link' => Html::a($job_site->nameText, ['job-site/view', 'id' => $job_site->id]),
				'name' => $job_site->street,
				'url' => Url::toRoute(['index', 'job_site' => $job_site->id]),
			];

		return $array;
	}

	public function actionInventories_json()
	{
		$array = [];
		foreach (Inventory::find()->with(['jobSite', 'tool', 'status'])->all() as $m)
		{
			$array[] = [
				'id' => $m->id,
				'url' => $m->url,
				'name' => $m->tool->name,
				'inventory_number' => $m->formattedNumber,
				'job_site' => $m->jobSite->street,
				'status' => $m->status->status,
			];
		}

		echo Json::encode($array);
	}
	
    /**
     * Displays a single Inventory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Inventory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Inventory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Inventory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Inventory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Inventory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Inventory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Inventory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
