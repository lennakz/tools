<?php

namespace app\controllers;

use Yii;

use yii\data\ActiveDataProvider;
use yii\data\Sort;

use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Inventory;

/**
 * InventoryController implements the CRUD actions for Inventory model.
 */
class InventoryController extends Controller
{
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
		$param = app()->request->get();
		if (empty($param))
		{
			$query = Inventory::find()->joinWith(['tool', 'jobSite', 'status']);
		}
		else
		{
			if (!empty($param['cat']))
				$query = Inventory::find()->where(['tools.category_id' => $param['cat']])->joinWith(['tool', 'jobSite', 'status']);
			elseif (!empty($param['status']))
				$query = Inventory::find()->where(['status_id' => $param['status']])->joinWith(['tool', 'jobSite', 'status']);
			elseif (!empty($param['job_site']))
				$query = Inventory::find()->where(['job_site_id' => $param['job_site']])->joinWith(['tool', 'jobSite', 'status']);
			else
				throw new NotFoundHttpException;
		}
			
		$dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => new Sort([
				'attributes' => [
					'id',
					'tool.name' => [
						'asc' => ['tool.name' => SORT_ASC],
						'desc' => ['tool.name' => SORT_DESC],
					],
					'jobSite.street' => [
						'asc' => ['jobSite.name' => SORT_ASC],
						'desc' => ['jobSite.name' => SORT_DESC],
					],
					'tool.category.name' => [
						'asc' => ['tool.category.name' => SORT_ASC],
						'desc' => ['tool.category.name' => SORT_DESC],
					],
					'status.status' => [
						'asc' => ['status.status' => SORT_ASC],
						'desc' => ['status.status' => SORT_DESC],
					],
				],
				'defaultOrder' => [
					'id' => SORT_ASC,
				],
			]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
		]);
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
	
	public function actionCategory($param1)
	{
		dump($_GET);exit;
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
	
	public function actionTest()
	{
		$make = array(
			array('id' => '2','name' => 'Makita'),
			array('id' => '3','name' => 'Milwaukee'),
			array('id' => '4','name' => 'Hitachi'),
			array('id' => '5','name' => 'Ryobi'),
			array('id' => '6','name' => 'Simpson'),
			array('id' => '7','name' => 'Bostitch'),
			array('id' => '8','name' => 'Hilti'),
			array('id' => '9','name' => 'Bosch'),
			array('id' => '10','name' => 'Dewalt'),
			array('id' => '11','name' => 'Max'),
			array('id' => '12','name' => 'Stanley'),
			array('id' => '13','name' => 'Sidewinder'),
			array('id' => '14','name' => 'Shop Vac'),
			array('id' => '15','name' => 'Graco'),
			array('id' => '16','name' => 'Sigma'),
			array('id' => '17','name' => 'Allright'),
			array('id' => '18','name' => 'Knaack'),
			array('id' => '19','name' => 'Featherlite'),
			array('id' => '20','name' => 'Leica'),
			array('id' => '21','name' => 'Mustang'),
			array('id' => '22','name' => 'Aardwolf'),
			array('id' => '23','name' => 'Snapper Shear Ss404'),
			array('id' => '24','name' => 'Power Source'),
			array('id' => '25','name' => 'Ox'),
			array('id' => '26','name' => 'Acculine Pro'),
			array('id' => '27','name' => 'Jobmaster'),
			array('id' => '28','name' => 'Green Lee'),
			array('id' => '29','name' => 'Empire'),
			array('id' => '30','name' => 'Senco'),
			array('id' => '31','name' => 'Paslode'),
			array('id' => '32','name' => 'Stihl'),
			array('id' => '33','name' => 'Crl'),
			array('id' => '34','name' => 'Skil'),
			array('id' => '35','name' => 'Red Lion'),
			array('id' => '36','name' => 'Rok'),
			array('id' => '37','name' => 'Tsurumi'),
			array('id' => '38','name' => '(Yellow)'),
			array('id' => '39','name' => 'Porter Cable'),
			array('id' => '40','name' => 'Open'),
			array('id' => '41','name' => 'Wobblelight'),
			array('id' => '42','name' => 'Black & Decker'),
			array('id' => '43','name' => '(Small)'),
			array('id' => '44','name' => 'Stein'),
			array('id' => '45','name' => 'King Canada'),
			array('id' => '46','name' => 'Stabila'),
			array('id' => '47','name' => '(Large)'),
			array('id' => '48','name' => 'Sector'),
			array('id' => '49','name' => 'Flex'),
			array('id' => '50','name' => 'Abaco'),
			array('id' => '51','name' => 'Dimplex'),
			array('id' => '52','name' => 'Task'),
			array('id' => '53','name' => 'Kapro'),
			array('id' => '54','name' => 'Accuglide'),
			array('id' => '55','name' => 'Combi'),
			array('id' => '56','name' => 'U-Line'),
			array('id' => '57','name' => 'Sturdy'),
			array('id' => '58','name' => 'Tuff'),
			array('id' => '59','name' => '(Medium)'),
			array('id' => '60','name' => 'Woods'),
			array('id' => '61','name' => 'Gundlach'),
			array('id' => '62','name' => 'Plump-Rite'),
			array('id' => '63','name' => 'Yellow')
		  );
		
		$str = "ANGLE GRINDER,MAKITA,;SAW,MAKITA,(1650W);RECIPROCATING SAW,MILWAUKEE,;JIG SAW,MAKITA,(SMALL);IMPACT DRIVER,MAKITA,DTD146;CHARGER,MILWAUKEE,(M12);DRILL/DRIVER,MAKITA,;GRINDER,MAKITA,(SMALL);HAMMER DRILL,MAKITA,;NAIL GUN (COIL),HITACHI,;PLANER,RYOBI,(YELLOW);CHARGER,MAKITA,;CHARGER,MAKITA,;(EDWIN\'S CHARGER),MILWAUKEE,;HAMMER DRILL,MILWAUKEE,;ANCHOR GUN (0.27),SIMPSON,;NAIL GUN (FLAT),BOSTITCH,;JIG SAW,MAKITA,;FASTENING GUN,HILTI,DX2;ANCHOR GUN (0.27),SIMPSON,;HAMMER DRILL,BOSCH,;CIRCULAR SAW,DEWALT,;CHARGER,DEWALT,;STAPLER,MAX,;TABLE SAW,DEWALT,;ROUTER,MILWAUKEE,;MARBLE SAW,DEWALT,;LASER CHALK,DEWALT,;COMPRESSOR,MAKITA,;MITRE SAW (COMPOUND),DEWALT,;STAPLER (HAND),STANLEY,;NAIL GUN (COIL),;CIRCULAR SAW,BOSCH,;CIRCULAR SAW,SIDEWINDER,;NAIL GUN,DEWALT,;RECIPROCATING SAW,MILWAUKEE,;CIRCULAR SAW,MAKITA,;COMPRESSOR,;COMPRESSOR,;CIRCULAR SAW,MAKITA,;VACUUM,SHOP VAC,ULTRA 8GAL;STRAY SYSTEM (BLUE),GRACO,390;UFO POLISHING MACHINE,;MAGNET ON WHEELS,;RECIPROCATING SAW,BOSCH,;NAIL GUN,HITACHI,;TILE CUTTER,SIGMA,;HEATER,(IP34);HEATER,(IP34);YAMAKOYO,;REBAR BENDER,HITACHI,;GAS CANISTER,;GAS CANISTER,;TILE HOLDER,SIGMA,;TILE HOLDER,SIGMA,;POWERWINDER,STANLEY,(60M/200\');DISPENSER,HILTI,MORTAR INJECTOR HDM500;LADDER,ALLRIGHT,;FIRE EXTINGUISHER,;TILE HOLDER,SIGMA,;STEP LADDER (3 STEP),;TOOL BOX (LARGE),KNAACK,;TOOL BOX,DEWALT,;STEP LADDER,FEATHERLITE,;LASER LEVEL,LEICA,;SAW HORSE,MUSTANG,;FIRE EXTINGUISHER,;DIESEL CAN,;VACUUM,SHOP VAC,16.5GAL;FIRE EXTINGUISHER,;SAW HORSE (SMALL),;VACUUM,SHOP VAC,16.5GAL;T-SQUARE (FOR DRYWALL),;T-SQUARE,;LEVEL,STANLEY,FATMAX EXTREME;LEVEL,ALLRIGHT,;LADDER (WOOD),;T-SQUARE,;SLAB LIFTER,AARDWOLF,SLAB LIFTER 50;MARBLE CLAMP,;MARBLE CLAMP,;WALL SCANNER,BOSCH,;CHARGER,MILWAUKEE,;7\" (WET) POLISHER,MAKITA,9227C;POLISHING MACHINE,MAKITA,;STONE SAW,BOSCH,1677M or CSW41 WORM DRIVE;HARDY CUTTER,SNAPPER SHEAR SS404,;DRILL/MIXER,MAKITA,;DRILL/MIXER,DEWALT,;ANGLE GRINDER,MAKITA,;BATTERY,MILWAUKEE,(FOR ANGLE GRINDER);ANGLE GRINDER,MAKITA,;DRILL/DRIVER,MAKITA,DHP481;MULTI-TOOL,BOSCH,MX30E;CAULKING GUN,;LIGHT (L.E.D. W/ STAND),MILWAUKEE,;LIGHT (L.E.D.),POWER SOURCE,;LEVEL,OX,PRO SERIES;NAIL GUN,MAKITA,;VACUUM (PORTABLE),MILWAUKEE,;BATTERY,MILWAUKEE,M12 XC4.0;IMPACT DRIVER,MILWAUKEE,;CHARGER,MILWAUKEE,M12;IMPACT DRIVER (FUEL),MILWAUKEE,;VACUUM,SHOP VAC,10GAL;LASER LEVEL,ACCULINE PRO,;NAIL GUN (18GA),MAX,BRAD NAILER NF255F;POWERLIGHT,;TOOL BOX,JOBMASTER,;IMPACT DRIVER,MAKITA,BTD140;TOOL BOX,GREEN LEE,;NAIL GUN (SMALL),MAKITA,2\" BRAD NAILER AF505W;CHARGER,MAKITA,;HAMMER DRILL,MAKITA,DHP458;ANGLE GRINDER,HITACHI,;VACUUM,SHOP VAC,16.5GAL;STAPLER,MILWAUKEE,;NAIL GUN,BOSTITCH,;NAIL GUN (PALM),;HAMMER DRILL,BOSCH,;ANGLE GRINDER,MAKITA,GA4530;COMPRESSOR,MAKITA,2.6GAL MAC700;CHARGER,MAKITA,;BELT SANDER,MAKITA,9040;PLANER,MAKITA,KPC800;TABLE SAW,BOSCH,;LADDER,;LADDER,;LADDER,;IMPACT DRIVER,MAKITA,DTD145;TRIPOD FOR LEVEL,;TRIPOD FOR LEVEL,;TRIPOD FOR LEVEL,;HEATER,;RECIPROCATING SAW,MAKITA,;CIRCULAR SAW,MAKITA,;ANGLE GRINDER,BOSCH,;ROUTER (3.5HP),MAKITA,;BATTERY,MAKITA,18V;BATTERY,MAKITA,18V;IMPACT DRIVER,MAKITA,;IMPACT DRIVER,MAKITA,DTD152;LEVEL,EMPIRE,;HEAT GUN,DEWALT,;RECIPROCATING SAW,MILWAUKEE,;FLASHLIGHT,MILWAUKEE,;HAMMER DRILL,MILWAUKEE,;RECIPROCATING SAW,MILWAUKEE,;FLASHLIGHT,MILWAUKEE,;HAMMER DRIVER,MILWAUKEE,2604-20;CIRCULAR SAW,DEWALT,;NAIL GUN,DEWALT,;BATTERY,DEWALT,20V;STAPLE GUN,MAX,SUPERSTAPLER TA551A;NAIL GUN,SENCO,;NAIL GUN,PASLODE,;RECIPROCATING SAW,MILWAUKEE,;RECIPROCATING SAW,MILWAUKEE,;NAIL GUN,PASLODE,;SANDER (BELT),MAKITA,;HEAT GUN,DEWALT,;(EMPTY),;CIRCULAR SAW,MAKITA,5007MGA;MULTI-TOOL,MAKITA,;CHARGER,MILWAUKEE,;CHARGER,MILWAUKEE,;SAWHORSE 2 STEPS,;CUT-OFF SAW (GAS),STIHL,;SAWHORSE 2 STEPS,;SAWHORSE 2 STEPS,;BATTERY,MAKITA,3.0AH;BATTERY,MAKITA,3.0AH;HEAT GUN,DEWALT,D26950;SUCTION CUP,CRL,;SUCTION CUP,CRL,;SUCTION CUP,CRL,;SUCTION CUP,CRL,;SUCTION CUP,CRL,;SUCTION CUP,CRL,;NAIL GUN,MAX,;NAIL GUN,MAX,;MULTI-TOOL,MAKITA,;JIG SAW,SKIL,;SANDER (PALM),;LASER LEVEL,DEWALT,;LASER LEVEL,DEWALT,;JIG SAW,BOSCH,JS470E;NAIL GUN,MAX,;STAPLE GUN,MAX,SUPERSTAPLER TA551A;DRILL (CORDED),MILWAUKEE,0299-20;JERRY CAN,;CIRCULAR SAW,MILWAUKEE,2731-20;CIRCULAR SAW,MILWAUKEE,2731-20;RECIPROCATING SAW,MILWAUKEE,;1/2\" HAMMER DRILL/DRIVER,MILWAUKEE,2704-20;1/4\" HEX IMPACT DRIVER,MILWAUKEE,2753-20;FLASHLIGHT,MILWAUKEE,;CHARGER,MILWAUKEE,(M12/M18);RECIPROCATING SAW,MILWAUKEE,;IMPACT DRIVER,MILWAUKEE,;HAMMER DRILL,MILWAUKEE,;FLASHLIGHT,MILWAUKEE,;CIRCULAR SAW,MILWAUKEE,;BATTERY,MILWAUKEE,M18;MULTI-TOOL (CORDLESS),MAKITA,DTM51;CIRCULAR SAW (M18),MILWAUKEE,2731-20;IMPACT DRIVER,MILWAUKEE,;DRILL/DRIVER,MILWAUKEE,BRUSHLESS;RECIPROCATING SAW,MILWAUKEE,;CHARGER,MILWAUKEE,(M12/M18);WORK LIGHT,MILWAUKEE,;CIRCULAR SAW,MILWAUKEE,;MULTI-TOOL,MAKITA,;CIRCULAR SAW (M18),MILWAUKEE,2731-20;RECIPROCATING SAW,MILWAUKEE,;CHARGER,MILWAUKEE,;HAMMER DRILL,MILWAUKEE,;IMPACT DRIVER,MILWAUKEE,;FLASHLIGHT,MILWAUKEE,;MULTI-TOOL,MAKITA,;ANGLE GRINDER (M18),MILWAUKEE,2780-20;LASER REPLACEMENT (???),DEWALT,;ANGLE GRINDER (M18),MILWAUKEE,2780-20;NAIL GUN,MAX,;LASER,BOSCH,;LASER,BOSCH,;TABLE SAW,DEWALT,;SAWHORSE 3 STEPS,;ROUTER,MAKITA,;DRILL/MIXER (SPADE HANDLE),MAKITA,1/2\" SPADE HANDLE DRILL DS4012;STAPLE GUN,MAX,SUPERSTAPLER TA551A;BRAD NAILER,MAX,SUPERFINISHER NF255F;CUT-OFF DRYWALL TOOL,MAKITA,;VACUUM,SHOP VAC,;HAMMER DRILL,MILWAUKEE,;RECIPROCATING SAW (CORDED),MILWAUKEE,;NAIL GUN (16GA),BOSTITCH,;WET TILE SAW,DEWALT,D24000;MITRE SAW (COMPOUND),DEWALT,DW713;MITRE SAW (DUAL-BEVEL GLIDE),BOSCH,GCM12SD;ANCHOR GUN (0.27),HILTI,DX2;FLASHLIGHT,MILWAUKEE,;DRYWALL CUTOUT TOOL (CORDLESS),MAKITA,DCO180;STAPLER (HAND),STANLEY,TR150;CAULKING GUN (CORDLESS),MAKITA,DCG180;SANDER (ORBITAL),MAKITA,BO5030;FIBRE CEMENT SHEAR,MAKITA,JS8000;JIG SAW,MAKITA,4350 FCT;MULTI-TOOL (CORDLESS),MAKITA,DTM51;ROUTER (3.5HP PLUNGE),MAKITA,RP1801F;STAPLE GUN,MAX,SUPERSTAPLER TA551B;AIR GUN,ROK,;IMPACT NAILER,BOSTITCH,PN100;ROUTER,MILWAUKEE,A19AD154500444;WATER PUMP,RED LION,RL33PS / 620041;WATER PUMP,TSURUMI,;WORK LIGHT,(YELLOW),;STAPLE GUN,PORTER CABLE,;VACUUM,SHOP VAC,ULTRA 16.5GAL;MITRE SAW (DOUBLE BEVEL SLIDING COMPOUND),DEWALT,(\"FINISHING ONLY\");OPEN,OPEN,OPEN;WORK LIGHT,WOBBLELIGHT,;NAIL GUN,SENCO,;DRILL/MIXER (SPADE HANDLE),MAKITA,1/2\" SPADE HANDLE DRILL DS4012;STONE SAW,DEWALT,;ANGLE GRINDER (5\"),MAKITA,GA5030;STONE SAW,DEWALT,;WORK LIGHT,WOBBLELIGHT,;WORK LIGHT,WOBBLELIGHT,;WORK LIGHT,(YELLOW),;WORK LIGHT,(YELLOW),;WORK LIGHT,(YELLOW),;WORK LIGHT,(YELLOW),;ANGLE GRINDER (5\"),MAKITA,GA5030;SANDER (BELT),BLACK & DECKER,;GRINDER (VARIABLE SPEED),MAKITA,;POLE SAW (ELECTRIC),RYOBI,RY43161;OPEN,;OPEN,;OPEN,;FIRE EXTINGUISHER,(SMALL),;WORK LIGHT,(YELLOW),;HAMMER DRILL,MAKITA,HR5212C;WORK LIGHT,(YELLOW),;LASER LEVEL,HILTI,PR 30-HVS A12;LASER RECEIVER HOLDER,HILTI,PRA 83;CHARGER,HILTI,;ANGLE GRINDER,MILWAUKEE,2781-20;NAIL GUN (3\" COIL),HITACHI,NV75AN;CUT-OFF SAW (GAS),STIHL,TS 420;ANGLE GRINDER,BOSCH,;NAIL GUN,MAX,SUPERFRAMER;DRILL/DRIVER,MILWAUKEE,M18;IMPACT DRIVER,MILWAUKEE,M18;ANGLE GRINDER (M18),MILWAUKEE,M18;RECIPROCATING SAW,MILWAUKEE,M18;CHARGER,MILWAUKEE,(M12/M18);COMPRESSOR (150PSI),PORTER CABLE,;CIRCULAR SAW (7-1/4\"),MAKITA,;MULTI-TOOL,STEIN,MULTIMASTER;DRILL/DRIVER,MILWAUKEE,;NAIL GUN (PALM),BOSTITCH,PN100;FASTENER (POWDER ACTUATED),HILTI,;LASER LEVEL,LEICA,JOGGER 24;CHARGER,MILWAUKEE,(M12/M18);NAIL GUN (PIN),SENCO,FINISHPRO 23LXP;RECIPROCATING SAW,MILWAUKEE,;CIRCULAR SAW,MAKITA,;NAIL GUN (COIL),MAX,CN890F;NAIL GUN (2-1/2\" COIL),HITACHI,NV65AH;HEAT GUN,KING CANADA,;LEVEL,STABILA,EXTENDABLE 7\' to 12\';LEVEL,OX,PROSERIES 6\';LEVEL,EMPIRE,4\';TABLE SAW,BOSCH,4100;SAW STAND,BOSCH,GRAVITY RISE TS3000;LASER LEVEL,LEICA,LINO L2P5;NAIL GUN (3\" COIL),HITACHI,;CIRCULAR SAW (CORDED),DEWALT,;SUCTION CUP,CRL,WOOD\'S POWR-GRIP 8\";SUCTION CUP,CRL,WOOD\'S POWR-GRIP 8\";SUCTION CUP,CRL,WOOD\'S POWR-GRIP 8\";SUCTION CUP,CRL,WOOD\'S POWR-GRIP 8\";VACUUM,SHOP VAC,QSP QUIET DELUXE;FIRE EXTINGUISHER,(SMALL),;FIRE EXTINGUISHER,(LARGE),;HAMMER DRILL,MAKITA,HR2631;STONE SAW,BOSCH,1677M or CSW41 WORM DRIVE;STONE ROUTER,SECTOR,TRIPLESPEED;WET TILE SAW,FLEX,CS 40 WET;DRILL/DRIVER,MILWAUKEE,2407-20;IMPACT DRIVER,MILWAUKEE,2452-20;ANGLE GRINDER (4-1/2\"),MAKITA,9564PCV;WET POLISHER,FLEX,LE 12-3 100 WET;SLAB DOLLY,ABACO,4 WHEEL SLAB DOLLY;LASER LEVEL,HILTI,PM 4-M;TRIPOD FOR LEVEL,HILTI,PMA 20 SMALL;WALLMOUNT FOR LEVEL,HILTI,PMA 79;LASER LEVEL,BOSCH,GLL3-80;TOOL BOX (LARGE),ROK,;GRINDER (5\"),MAKITA,GA5030;HEATER,DIMPLEX,DCH4831L;HEATER,DIMPLEX,DCH4831L;SUPPORT ROD,TASK,T74490;SUPPORT ROD,TASK,T74490;SUPPORT ROD,TASK,T74490;SUPPORT ROD,TASK,T74490;SUPPORT ROD,TASK,T74505;SUPPORT ROD,TASK,T74505;CLAMP,SIGMA,;RAIL FOR WET SAW,12.5\';RAIL FOR WET SAW,5\';RAIL FOR WET SAW,8\';RAIL FOR WET SAW,8\';RAIL FOR WET SAW,8\' EXTENSION RAIL;LEVEL,KAPRO,OPTIVISION 4\';LEVEL,STABILA,3\';LEVEL,STABILA,8\';LEVEL,STABILA,6.5\';LEVEL,OX,PROSERIES 2\';LEVEL,OX,PROSERIES 6\';SLAB TILT TABLE,ACCUGLIDE,EZ-TILT;STONE SAW (LARGE),COMBI,COMBI 250;MARBLE CLAMP,;MARBLE CLAMP,;LEVEL,STABILA,4\' (37448 TYPE 196-2);HEATER,FAN-FORCED ELECTRIC (black 1500W);HEATER,FAN-FORCED ELECTRIC (black 1500W);HAMMER DRILL,MAKITA,6013BR;HAMMER DRILL/DRIVER,MILWAUKEE,2604-20;DRILL/MIXER (SPADE HANDLE),MAKITA,1/2\" SPADE HANDLE DRILL DS4012;LEVEL,STABILA,3\' (37436 TYPE 196-2);WORK LIGHT,(YELLOW),;PALLET JACK,U-LINE,H-2721;GRINDER,BOSCH,;LED WALL PACK,;LED WALL PACK,;LED WALL PACK,;LADDER,ALLRIGHT,6\' WOOD;SAW HORSE,ALLRIGHT,4\' ALUMINUM;SAW HORSE,STURDY,3\' ALUMINUM;WHEEL BARROW,TUFF,;SAW HORSE,ALLRIGHT,4\' ALUMINUM;LED WALL PACK,;VACUUM,SHOP VAC,ULTRA 8GAL;SAW STAND,DEWALT,DWX726;FIRE EXTINGUISHER,(MEDIUM),;SAW HORSE,ALLRIGHT,5\' ALUMINUM;SAW HORSE,ALLRIGHT,3\' ALUMINUM;LEVEL,STABILA,32\" (TYPE 192-2);SAW HORSE,ALLRIGHT,3\' ALUMINUM;SAW HORSE,ALLRIGHT,3\' ALUMINUM;SAW HORSE,ALLRIGHT,3\' ALUMINUM;SAW HORSE,ALLRIGHT,3\' ALUMINUM;WORK LIGHT,WOODS,POWERLIGHT;TABLE SAW,DEWALT,DWE7480;LEVEL,KAPRO,OPTIVISION 6\';STRAIGHT EDGE,GUNDLACH,No. 30-8;WATER PUMP,839;PLUMB BOB,PLUMP-RITE,1720;WORK LIGHT,YELLOW,1739;;";
	
		foreach ($make as $a)
		{
			//dump(strtoupper($a['name']));
			$str = str_replace(strtoupper($a['name']), $a['id'], $str);
		}
		
		dump($str);exit;
		
	}
}
