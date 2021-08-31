<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\models\ContactForm;
use app\models\InputData;
use app\models\addrec;
use app\models\InputDataBudget;
use app\models\InputDataOst;
use app\models\diary_e;
use app\models\list_workers;
use app\models\requestsearch;
use app\models\tofile;
use app\models\forExcel;
use app\models\tovar;
use app\models\spr_typeact;
use app\models\service;
use app\models\view_budget;
use app\models\spr_typerepair;
use app\models\spr_typetmc;
use app\models\spr_spec;
use app\models\spr_obj;
use app\models\spr_page;
use app\models\spr_edizm;
use app\models\tmc_res;
use app\models\grup;
use app\models\rem;
use app\models\info;
use app\models\analytics;
use app\models\analytics_ost;
use app\models\budget;
use app\models\budget_res;
use app\models\User;
use app\models\loginform;
use yii\web\UploadedFile;

class SiteController extends Controller
{  /**
 *
 * @return type
 *
 */

    public $curpage;

    public function behaviors()
    {
        return [
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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


    //  Происходит при запуске сайта
    public function actionIndex()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect(['site/more']);
        }
        if(strpos(Yii::$app->request->url,'/cek')==0)
            return $this->redirect(['site/more']);
        $model = new loginform();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['site/more']);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    //  Происходит при запуске сайта
    public function actionCek()
    {
        $model = new loginform();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['site/more']);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }


    //  Происходит после ввода пароля
    public function actionMore($sql='0')
    {
        $model = new info();
        $model->title = 'Про сайт';
        $model->info1 = "За допомогою цього сайту здійснюється перегляд товарів, виділених для РЕМ, а також редагування їх залишку.";
        $model->style1 = "d15";
        $model->style2 = "info-text";
        $model->style_title = "d9";

        return $this->render('about', [
            'model' => $model]);
    }
                
    //  Происходит после нажатия на пункт меню: "Остатки РЭС"
      public function actionOst($sql='0')
    {
        ini_set('max_execution_time', 900);
        if($sql=='0') {

            $model = new InputDataOst();
            $where=' where 1=1 ';
            if ($model->load(Yii::$app->request->post())) {

                $session = Yii::$app->session;
                $session->open();
                if ($session->has('user'))
                    $user = $session->get('user');
                else
                    $user = '';
                $searchModel = new View_budget();

                // Создание поискового sql выражения
                if (!empty($user) && $user <> 'all' and let_all($user)<>1)
                    $where = ' where name_service = ' . "'" . $user . "'";
                if ($user == 'all' || let_all($user)==1) {
                    if ($model->name_service == -1)
                        $where = ' where 1=1 ';
                    else {
                        $mrem = rem::find()->where('ID=:id', [':id' => $model->name_service])->all();
                        $nazv_rem = $mrem[0]->rem;
                        $where = ' where name_service=' . "'" . $nazv_rem . "'";
                    }
                }
                if (!empty($model->type_act)) {
                    if(trim($model->type_act)<>-1)
                        $where .= ' and type_act=' . $model->type_act ;
                }
                if (!empty($model->spec)) {

                    $mgrup = grup::find()->where('ID=:id', [':id' => $model->spec])->all();
                    $nazv_gr = $mgrup[0]->grup;
                    $where .= ' and spec=' . '"' . $nazv_gr . '"';
                }

                if (!empty($model->obj)) {
                    if(trim($model->obj)<>1)
                        $where .= ' and name_obj=' . $model->obj ;
                }

                if (!empty($model->n_cnt)) {
                     $where .= ' and n_cnt=' . $model->n_cnt ;
                }

                if (!empty($model->type_tmc)) {
                    if(trim($model->type_tmc)<>-1)
                        $where .= ' and vid_tmc=' . $model->type_tmc ;
                }

                if (!empty($model->type_repair)) {
                    if(trim($model->type_repair)<>-1)
                        $where .= ' and vid_repair=' . $model->type_repair ;
                }

                // Поиск по нескольким видам ремонта
                $ss='';
                $flg=0;
                for($vj=1;$vj<7;$vj++){
                    $v=$model->{'r'.$vj};

                    if($v){
                        $flg=1;
                        $ss .= 'vid_repair=' . $vj. ' or ' ;
                    }

                }
                if($flg==1) {
                    $ss = substr($ss, 0, strlen($ss) - 4);
                    $where .= ' and (' . $ss . ')';
                }

                // Поиск по нескольким разделам закупки
                $ss = '';
                $flg = 0;
                $srv = spr_spec::find()->asarray()->all();
                $k_spc = count($srv);

                for ($vj = 1; $vj <= $k_spc; $vj++) {
                    $v = $model->{'sp' . $vj};

                    if ($v) {
                        $flg = 1;
                        $ss .= 'name_spec=' . $vj . ' or ';
                    }

                }
                if ($flg == 1) {
                    $ss = substr($ss, 0, strlen($ss) - 4);
                    $where .= ' and (' . $ss . ')';
                }

                // Поиск по нескольким подразделениям
                $ss='';
                $flg=0;
                $srv = tovar::findbysql(
                    "select ID,rem
                                from vw_rem ")->asarray()->all();
                $k_srv=count($srv);

                for($vj=1;$vj<=$k_srv;$vj++){
                    $v=$model->{'s'.$vj};
                    $sj=0;
                    foreach ($srv as $q){
                        $sj++;
                        if($sj==$vj && $v==1) {
                            $ss .=$q['ID'].',';
                        }
                    }
                    if($ss<>''){
                        $flg=1;
                    }

                }
                if($flg==1) {
                    $ss = substr($ss, 0, strlen($ss) - 1);
                    $where .= ' and service in 
                    (select a.id from spr_service a,vw_rem b where a.service=b.rem and b.ID in('.$ss.'))';
                }
//                debug($ss);
//                return;

                if (!empty($model->name_tmc)) {
                    $where .= ' and name_tmc like ' . '"%' . $model->name_tmc . '%"';
                }


                $m = intval(date('n'));
                if (empty($model->m1)){
                    $s = $model->gen_nakop(1,$m);
                    $s_nakop_q = $model->gen_nakop(1,$m,'nakop_q');
                    $s_nakop = $model->gen_nakop(1,$m,'nakop');
                    $s_nakop_v = $model->gen_nakop(1,$m,'nakop_v');
                    $s_nakop_y = $model->gen_nakop(1,$m,'nakop_y');
                    $s_nakop_z = $model->gen_nakop(1,$m,'nakop_z');
                }
                if (!empty($model->m1) && !empty($model->m2)){
                    $m1 = $model->m1;
                    $m2 = $model->m2;
                    $s = $model->gen_nakop($m1,$m2);
                    $s_nakop_q = $model->gen_nakop($m1,$m2,'nakop_q');
                    $s_nakop = $model->gen_nakop($m1,$m2,'nakop');
                    $s_nakop_v = $model->gen_nakop($m1,$m2,'nakop_v');
                    $s_nakop_z = $model->gen_nakop($m1,$m2,'nakop_z');
                    $s_nakop_y = $model->gen_nakop($m1,$m2,'nakop_y');
                }


                if (!empty($model->nakop_q) || trim($model->nakop_q) === '0' || ($model->znakop_q)>6) {
                    $sign = f_sign($model->znakop_q);
                    $fsign=substr($sign,0,1);
                    if($fsign<>'-')
                        $where .= ' and ' . $s_nakop_q. $sign . $model->nakop_q;
                    else
                    {
                        if($sign=='-1')
                            $where .= ' and (' . $s_nakop_q. ' is null or '.$s_nakop_q.'=0)';
                        if($sign=='-2')
                            $where .= ' and (' . $s_nakop_q. ' is not null and '.$s_nakop_q.'<>0)';
                    }


                }

                if (!empty($model->nakop_v) || trim($model->nakop_v) === '0' || ($model->znakop_v)>6) {
                    $sign = f_sign($model->znakop_v);
                    $fsign=substr($sign,0,1);
                    if($fsign<>'-')
                        $where .= ' and ' . $s_nakop_v. $sign . $model->nakop_v;
                    else
                    {
                        if($sign=='-1')
                            $where .= ' and (' . $s_nakop_v. ' is null or '.$s_nakop_v.'<=0)';
                        if($sign=='-2')
                            $where .= ' and (' . $s_nakop_v. ' is not null and '.$s_nakop_v.'<>0)';
                    }


                }

                if (!empty($model->nakop) || trim($model->nakop) === '0' || ($model->znakop)>6) {
                    $sign = f_sign($model->znakop);
                    $fsign=substr($sign,0,1);
                    if($fsign<>'-')
                        $where .= ' and ' . $s_nakop. $sign . $model->nakop;
                    else
                    {
                        if($sign=='-1')
                            $where .= ' and (' . $s_nakop. ' is null or '.$s_nakop.'=0)';
                        if($sign=='-2')
                            $where .= ' and (' . $s_nakop. ' is not null and '.$s_nakop.'<>0)';
                    }
                }

                $having='';
                if (!empty($model->nakop_y) || trim($model->nakop_y) === '0' || ($model->znakop_y)>6) {
                    $sign = f_sign($model->znakop_y);
                    $fsign=substr($sign,0,1);
                    if($fsign<>'-')
                         $having=' having (min(nakop_v)-sum(nakop))'.$sign . $model->nakop_y;
                    else
                    {
                        if($sign=='-1')
                            $having=' having (min(nakop_v)-sum(nakop)) is null or (min(nakop_v)-sum(nakop))=0';
                        if($sign=='-2')
                            $having=' having (min(nakop_v)-sum(nakop)) is not null and (min(nakop_v)-sum(nakop))<>0';
                    }
                }
                if (!empty($model->nakop_z) || trim($model->nakop_z) === '0' || ($model->znakop_z)>6) {
                    $sign = f_sign($model->znakop_z);
                    $fsign=substr($sign,0,1);
                    if($fsign<>'-')
                        $where .= ' and ' . $s_nakop_z. $sign . $model->nakop_z;
                    else
                    {
                        if($sign=='-1')
                            $where .= ' and (' . $s_nakop_z. ' is null or '.$s_nakop_z.'<=0)';
                        if($sign=='-2')
                            $where .= ' and (' . $s_nakop_z. ' is not null and '.$s_nakop_z.'<>0)';
                    }
                }

                $sql = "(SELECT ".$s." FROM vw_budget " . $where . ' ORDER BY name_service) u ';
                $zsql='select type_tmc,name_tmc,edizm,price,spec,name_service,n_cnt,d_cnt,cagent,sum(nakop) as nakop,
                sum(nakop_q) as nakop_q,min(nakop_v) as nakop_v,(min(nakop_v)-sum(nakop)) as nakop_y,
                sum(nakop_z) as nakop_z from '.$sql.'group by name_tmc,edizm,
                price,spec,name_service,type_tmc,n_cnt,d_cnt,cagent';
                if($having<>'') $zsql .=$having;

//                debug($sql);
//                return;

                $data = view_budget::findBySql($zsql)->all();

//                debug($data);
//                return;

                $kol = count($data);
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $zsql);
                $dataProvider->pagination = false;

                return $this->render('view_ost', [
                    'model' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel, 'user' => $user,
                    'kol' => $kol, 'sql' => $zsql
                ]);

            } else {
                $repair = spr_typerepair::find()->asarray()->all();
                $spec = spr_spec::find()->asarray()->all();
                $service = tovar::findbysql(
                    "select ID,rem
                                from vw_rem ")->asarray()->all();
                //where ID>0
                $flag = 1;
                $role = 0;
                if (!isset(Yii::$app->user->identity->role)) {
                    $flag = 0;
                } else {
                    $role = Yii::$app->user->identity->role;
                }
                return $this->render('inputdataost', [
                    'model' => $model, 'role' => $role,
                    'repair' =>$repair,
                    'service' =>$service,
                    'spec' =>$spec

                ]);
            }

        }
        else{
            // Если передается параметр $sql
            $data = tovar::findBySql($sql)->all();
            $searchModel = new view_budget();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $sql);
            $kol = count($data);

            $session = Yii::$app->session;
            $session->open();
            $session->set('view', 1);

            return $this->render('view_budget', ['model' => $data,
                'dataProvider' => $dataProvider, 'searchModel' => $searchModel, 'kol' => $kol, 'sql' => $sql]);
        }
    }


    //  Происходит после нажатия на пункт меню: "Бюджет"
    public function actionBudget($sql='0',$res='',$tovar='')
    {
        ini_set('max_execution_time', 900);
        if($sql=='0') {

            $model = new InputDataBudget();
            if ($res <> '' && $tovar <> '' )
                // Происходит при детализации из остатка РЭС
                $where = ' where name_service=' . '"' . $res . '"' .
                    ' and name_tmc=' . '"' . $tovar . '"';
            else
                $where = ' where 1=1 ';
            if(($res=='' && $tovar=='')) {
                if ($model->load(Yii::$app->request->post())) {

                    $session = Yii::$app->session;
                    $session->open();
                    if ($session->has('user'))
                        $user = $session->get('user');
                    else
                        $user = '';
                    $searchModel = new View_budget();

                    // Создание поискового sql выражения
                    if (!empty($user) && $user <> 'all' and let_all($user) <> 1)
                        $where = ' where name_service = ' . "'" . $user . "'";
                    if ($user == 'all' || let_all($user) == 1) {
                        if ($model->name_service == -1)
                            $where = ' where 1=1 ';
                        else {
                            $mrem = rem::find()->where('ID=:id', [':id' => $model->name_service])->all();
                            $nazv_rem = $mrem[0]->rem;
                            $where = ' where name_service=' . "'" . $nazv_rem . "'";
                        }
                    }
                    if (!empty($model->type_act)) {
                        if (trim($model->type_act) <> -1)
                            $where .= ' and type_act=' . $model->type_act;
                    }
                    if (!empty($model->spec)) {

                        $mgrup = grup::find()->where('ID=:id', [':id' => $model->spec])->all();
                        $nazv_gr = $mgrup[0]->grup;
                        $pos = strpos($nazv_gr, "'");
//                        if ($pos === false)
//                            $where .= ' and spec=' . "'" . $nazv_gr . "'";
//                        else
//                            $where .= ' and spec=' . '"' . $nazv_gr . '"';
                        $nazv_gr=str_replace("'",'',$nazv_gr);

                        $where .= ' and spec=' . "'" . $nazv_gr . "'";
                    }

                    if (!empty($model->add_rec)) {

                        $where .= ' and id_zakaz=1 ';
                    }

                    if (!empty($model->obj)) {
                        if (trim($model->obj) <> 1)
                            $where .= ' and name_obj=' . $model->obj;
                    }

                    if (!empty($model->type_tmc)) {
                        if (trim($model->type_tmc) <> -1)
                            $where .= ' and vid_tmc=' . $model->type_tmc;
                    }

                    if (!empty($model->type_repair)) {
                        if (trim($model->type_repair) <> -1)
                            $where .= ' and vid_repair=' . $model->type_repair;
                    }

                    // Поиск по нескольким видам ремонта
                    $ss = '';
                    $flg = 0;
                    for ($vj = 1; $vj < 7; $vj++) {
                        $v = $model->{'r' . $vj};

                        if ($v) {
                            $flg = 1;
                            $ss .= 'vid_repair=' . $vj . ' or ';
                        }

                    }
                    if ($flg == 1) {
                        $ss = substr($ss, 0, strlen($ss) - 4);
                        $where .= ' and (' . $ss . ')';
                    }

                    // Поиск по нескольким разделам закупки
                    $ss = '';
                    $flg = 0;
                    $srv = spr_spec::find()->asarray()->all();
                    $k_spc = count($srv);

                    for ($vj = 1; $vj <= $k_spc; $vj++) {
                        $v = $model->{'sp' . $vj};

                        if ($v) {
                            $flg = 1;
                            $ss .= 'name_spec=' . $vj . ' or ';
                        }

                    }
                    if ($flg == 1) {
                        $ss = substr($ss, 0, strlen($ss) - 4);
                        $where .= ' and (' . $ss . ')';
                    }

                    // Поиск по нескольким подразделениям
                    $ss = '';
                    $flg = 0;
                    $srv = tovar::findbysql(
                        "select ID,rem
                                from vw_rem ")->asarray()->all();
                    $k_srv = count($srv);

                    for ($vj = 1; $vj <= $k_srv; $vj++) {
                        $v = $model->{'s' . $vj};
                        $sj = 0;
                        foreach ($srv as $q) {
                            $sj++;
                            if ($sj == $vj && $v == 1) {
                                $ss .= $q['ID'] . ',';
                            }
                        }
                        if ($ss <> '') {
                            $flg = 1;
                        }

                    }
                    if ($flg == 1) {
                        $ss = substr($ss, 0, strlen($ss) - 1);
                        $where .= ' and service in 
                    (select a.id from spr_service a,vw_rem b where a.service=b.rem and b.ID in(' . $ss . '))';
                    }
//                debug($ss);
//                return;

                    if (!empty($model->name_tmc)) {
                        $where .= ' and name_tmc like ' . '"%' . $model->name_tmc . '%"';
                    }

                    if (!empty($model->dname)) {
                        $where .= ' and dname_obj like ' . '"%' . $model->dname . '%"';
                    }


                    $m = intval(date('n'));
                    if (empty($model->m1)) {
                        $s = $model->gen_nakop(1, $m);
                        $s_nakop_q = $model->gen_nakop(1, $m, 'nakop_q');
                        $s_nakop = $model->gen_nakop(1, $m, 'nakop');
                        $s_nakop_o = $model->gen_nakop(1, $m, 'nakop_o');
                        $s_nakop_z = $model->gen_nakop(1, $m, 'nakop_z');
                        $s_nakop_n = $model->gen_nakop(1, $m, 'nakop_n');
                        $s_nakop_v = $model->gen_nakop(1, $m, 'nakop_v');
                    }
                    if (!empty($model->m1) && !empty($model->m2)) {
                        $m1 = $model->m1;
                        $m2 = $model->m2;
                        $s = $model->gen_nakop($m1, $m2);
                        $s_nakop_q = $model->gen_nakop($m1, $m2, 'nakop_q');
                        $s_nakop = $model->gen_nakop($m1, $m2, 'nakop');
                        $s_nakop_o = $model->gen_nakop($m1, $m2, 'nakop_o');
                        $s_nakop_z = $model->gen_nakop($m1, $m2, 'nakop_z');
                        $s_nakop_n = $model->gen_nakop($m1, $m2, 'nakop_n');
                        $s_nakop_v = $model->gen_nakop($m1, $m2, 'nakop_v');;
                    }


                    if (!empty($model->nakop_q) || trim($model->nakop_q) === '0' || ($model->znakop_q) > 6) {
                        $sign = f_sign($model->znakop_q);
                        $fsign = substr($sign, 0, 1);
                        if ($fsign <> '-')
                            $where .= ' and ' . $s_nakop_q . $sign . $model->nakop_q;
                        else {
                            if ($sign == '-1')
                                $where .= ' and (' . $s_nakop_q . ' is null or ' . $s_nakop_q . '=0)';
                            if ($sign == '-2')
                                $where .= ' and (' . $s_nakop_q . ' is not null and ' . $s_nakop_q . '<>0)';
                        }


                    }

                    if (!empty($model->nakop_v) || trim($model->nakop_v) === '0' || ($model->znakop_v) > 6) {
                        $sign = f_sign($model->znakop_v);
                        $fsign = substr($sign, 0, 1);
                        if ($fsign <> '-')
                            $where .= ' and ' . $s_nakop_v . $sign . $model->nakop_v;
                        else {
                            if ($sign == '-1')
                                $where .= ' and (' . $s_nakop_v . ' is null or ' . $s_nakop_v . '=0)';
                            if ($sign == '-2')
                                $where .= ' and (' . $s_nakop_v . ' is not null and ' . $s_nakop_v . '<>0)';
                        }


                    }

                    if (!empty($model->nakop) || trim($model->nakop) === '0' || ($model->znakop) > 6) {
                        $sign = f_sign($model->znakop);
                        $fsign = substr($sign, 0, 1);
                        if ($fsign <> '-')
                            $where .= ' and ' . $s_nakop . $sign . $model->nakop;
                        else {
                            if ($sign == '-1')
                                $where .= ' and (' . $s_nakop . ' is null or ' . $s_nakop . '=0)';
                            if ($sign == '-2')
                                $where .= ' and (' . $s_nakop . ' is not null and ' . $s_nakop . '<>0)';
                        }
                    }
                    if (!empty($model->nakop_o) || trim($model->nakop_o) === '0' || ($model->znakop_o) > 6) {
                        $sign = f_sign($model->znakop_o);
                        $fsign = substr($sign, 0, 1);
                        if ($fsign <> '-')
                            $where .= ' and ' . $s_nakop_o . $sign . $model->nakop_o;
                        else {
                            if ($sign == '-1')
                                $where .= ' and (' . $s_nakop_o . ' is null or ' . $s_nakop_o . '=0)';
                            if ($sign == '-2')
                                $where .= ' and (' . $s_nakop_o . ' is not null and ' . $s_nakop_o . '<>0)';
                        }
                    }
                    if (!empty($model->nakop_z) || trim($model->nakop_z) === '0' || ($model->znakop_z) > 6) {
                        $sign = f_sign($model->znakop_z);
                        $fsign = substr($sign, 0, 1);
                        if ($fsign <> '-')
                            $where .= ' and ' . $s_nakop_z . $sign . $model->nakop_z;
                        else {
                            if ($sign == '-1')
                                $where .= ' and (' . $s_nakop_z . ' is null or ' . $s_nakop_z . '=0)';
                            if ($sign == '-2')
                                $where .= ' and (' . $s_nakop_z . ' is not null and ' . $s_nakop_z . '<>0)';
                        }

                    }
                    if (!empty($model->nakop_n) || trim($model->nakop_n) === '0' || ($model->znakop_n) > 6) {
                        $sign = f_sign($model->znakop_n);
                        $fsign = substr($sign, 0, 1);
                        if ($fsign <> '-')
                            $where .= ' and ' . $s_nakop_n . $sign . $model->nakop_n;
                        else {
                            if ($sign == '-1')
                                $where .= ' and (' . $s_nakop_n . ' is null or ' . $s_nakop_n . '=0)';
                            if ($sign == '-2')
                                $where .= ' and (' . $s_nakop_n . ' is not null and ' . $s_nakop_n . '<>0)';
                        }
                    }

                    $sql = "SELECT " . $s . " FROM vw_budget " . $where . ' ORDER BY id_zakaz desc,name_service';
                    $data = view_budget::findBySql($sql)->all();
//                debug($sql);
//                return;
                    $kol = count($data);
                    $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $sql);
                    $dataProvider->pagination = false;

                    return $this->redirect(['site/view_budget',
                        'sql' => $sql]);

//                    return $this->render('view_budget', [
//                        'model' => $searchModel,
//                        'dataProvider' => $dataProvider,
//                        'searchModel' => $searchModel, 'user' => $user,
//                        'kol' => $kol, 'sql' => $sql
//                    ]);

                } else {
                    $repair = spr_typerepair::find()->asarray()->all();
                    $spec = spr_spec::find()->asarray()->all();
                    $service = tovar::findbysql(
                        "select ID,rem
                                from vw_rem ")->asarray()->all();
                    //where ID>0
                    $flag = 1;
                    $role = 0;
                    if (!isset(Yii::$app->user->identity->role)) {
                        $flag = 0;
                    } else {
                        $role = Yii::$app->user->identity->role;
                    }
                    return $this->render('inputdatabudget', [
                        'model' => $model, 'role' => $role,
                        'repair' => $repair,
                        'service' => $service,
                        'spec' => $spec,

                    ]);
                }
            }
        else {
                // Детализация
                $searchModel = new View_budget();
                $session = Yii::$app->session;
                $session->open();
                if ($session->has('user'))
                    $user = $session->get('user');
                else
                    $user = '';
                $m = intval(date('n'));
                $s = $model->gen_nakop(1, $m);
                $sql = "SELECT " . $s . " FROM vw_budget " . $where . ' ORDER BY name_service';
                $data = view_budget::findBySql($sql)->all();
//                debug($sql);
//                return;
                $kol = count($data);
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $sql);
                $dataProvider->pagination = false;

                return $this->render('view_budget', [
                    'model' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel, 'user' => $user,
                    'kol' => $kol, 'sql' => $sql
                ]);


            }

        }
        else{
            // Если передается параметр $sql
            $data = tovar::findBySql($sql)->all();
            $searchModel = new view_budget();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $sql);
            $kol = count($data);

            $session = Yii::$app->session;
            $session->open();
            $session->set('view', 1);

            return $this->render('view_budget', ['model' => $data,
                'dataProvider' => $dataProvider, 'searchModel' => $searchModel, 'kol' => $kol, 'sql' => $sql]);
        }
    }

    public function actionView_budget($sql) {
        $session = Yii::$app->session;
        $session->open();
        if ($session->has('user'))
            $user = $session->get('user');
        else
            $user = '';
        $searchModel = new View_budget();
        $data = view_budget::findBySql($sql)->all();
        $kol = count($data);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $sql);
        $dataProvider->pagination = false;

        return $this->render('view_budget', [
            'model' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel, 'user' => $user,
            'kol' => $kol, 'sql' => $sql
        ]);

    }

//  Происходит после нажатия на кнопку Детально
    public function actionDetal() {
        $id = Yii::$app->request->post('id');
        $tovar = Yii::$app->request->post('tovar');
        $rem = Yii::$app->request->post('rem');

        $searchModel = new View_budget();
        $session = Yii::$app->session;
        $session->open();
        if ($session->has('user'))
            $user = $session->get('user');
        else
            $user = '';
        $m = intval(date('n'));
        $s = '';
        $s1='';
        $s2='';
        $s3='';
        $s4='';
        $s5='';
        $s6='';
        $s7='';
        for($i=1;$i<=$m;$i++){
            $s.='rq_'.$i.'+';
            $s1.='rp_'.$i.'+';
            $s2.='oq_'.$i.'+';
            $s3.='q_'.$i.'+';
            $s4.='p_'.$i.'+';
            $s5.='rn_'.$i.'+';
            $s6.='rz_'.$i.'+';
            $s7.='rx_'.$i.'+';
        }
        $s='*,('.substr($s,0,strlen($s)-1).') as nakop,('.
            substr($s1,0,strlen($s1)-1).') as nakop_s,('.
            substr($s2,0,strlen($s2)-1).') as nakop_o,('.
            substr($s3,0,strlen($s3)-1).') as nakop_q,('.
            substr($s4,0,strlen($s4)-1).') as nakop_p,('.
            substr($s5,0,strlen($s5)-1).') as nakop_n,('.
            substr($s6,0,strlen($s6)-1).') as nakop_z,('.
            substr($s7,0,strlen($s7)-1).') as nakop_x';
        $where = ' where id_zakaz='.$id;
        $sql = "SELECT ".$s." FROM vw_budget " . $where ;
        $data = view_budget::findBySql($sql)->all();

        $kol = count($data);
        if($kol==0) {
            $where = ' where name_tmc='."'".$tovar."'" . ' and name_service='."'".$rem."'";
            $sql = "SELECT ".$s." FROM vw_budget " . $where ;
            $data = view_budget::findBySql($sql)->all();
            $kol = count($data);
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $sql);

        return $this->render('view_budget', [
            'model' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel, 'user' => $user, 'kol' => $kol, 'sql' => $sql
        ]);

    }


    //    Удаление записей из справочника
    public function actionDelete($id,$mod)
    {   // $id  id записи
        // $mod - название модели
        // $sql- sql запрос, с помощью которого были извлечены данные перед удалением
        if($mod=='diary') {
            $model = diary_e::findOne($id);
            $model->delete();  // Удаление записи из списка рабочих
        }
        return $this->redirect(['site/diary']);
    }
    
    
     //    Удаление записей из справочника (Працівники)
    public function actionDelete_emp($id,$mod)
    {   // $id  id записи
        // $mod - название модели
        if($mod=='viewphone')
        {
        $model = list_workers::findOne($id);
        $tab_nom = $model->tab_nom;
        $model->delete();  // Удаление записи из списка рабочих
        $data_mob = kyivstar::find()->select('id')
                ->where('tab_nom=:tab_nom', [':tab_nom' => $tab_nom])->one();
        if(!empty($data_mob->id))
            $data_mob->delete(); // Удаление записи из списка мобильных телефонов
        $data = hipatch::find()->select('id')
                ->where('tab_nom=:tab_nom', [':tab_nom' => $tab_nom])->one();
        if(!empty($data->id))
             $data->delete();     // Удаление записи из списка внутренних и городских телефонов
        }
        return $this->redirect(['site/employees']);
    }
    
    
    //    ~ Обновление записи
    public function actionUpdate($id,$mod,$sql)
    {
        // $id  id записи
        // $mod - название модели
        if($mod=='ost')
              $model = tovar::find()
                ->where('id=:id', [':id' => $id])->one();

        $session = Yii::$app->session;
        $session->open();
        if($session->has('user'))
            $user = $session->get('user');
        else
            $user = '';

        if ($model->load(Yii::$app->request->post()))
        {
            if($model->ost_res>$model->kol_give){
                Yii::$app->session->setFlash('error',"Увага! Залишок більше ніж видано, збереження неможливе.");
                return $this->refresh();
            }
//            else
//                Yii::$app->session->setFlash('error',"Увага! Залишок більше ніж видано, збереження неможливе.");

            $m = intval(date('n'));
            if($m<10)
                $month = '0'.$m;
            else
                $month = $m;
            // Обновление остатков РЭСа
            $z = "UPDATE tmc_res 
                    SET "."`".$month."`=".$model->ost_res.
                    " WHERE ID = ".$id;

            Yii::$app->db->createCommand($z)->execute();

            if($mod=='ost')
                $this->redirect(['site/ost','sql' => $sql]);

        } else {
            if($mod=='ost')
            return $this->render('update_ost', [
                'model' => $model
            ]);
        }
    }

    //    ~ Удаление записи
    public function actionDelete_budget($id,$mod,$sql)
    {

        $model = budget::find()
        ->where('id=:id', [':id' => $id])->one();

        $model->delete();

        $model = budget_res::find()
            ->where('id_budget=:id', [':id' => $id])->one();

        $model->delete();

        $this->redirect(['site/budget','sql' => $sql]);

    }



    //    ~ Обновление записи
    public function actionUpdate_budget($id,$mod,$sql)
    {
        // $id  id записи
        // $mod - название модели
        if($mod=='budget')
            $model = view_budget::find()
                ->where('id=:id', [':id' => $id])->one();

        $session = Yii::$app->session;
        $session->open();
        if($session->has('user'))
            $user = $session->get('user');
        else
            $user = '';

        if ($model->load(Yii::$app->request->post()))
        {
//            if($model->ost_res>$model->kol_give){
//                Yii::$app->session->setFlash('error',"Увага! Залишок більше ніж видано, збереження неможливе.");
//                return $this->refresh();
//            }
//            else
//                Yii::$app->session->setFlash('error',"Увага! Залишок більше ніж видано, збереження неможливе.");


            // Обновление остатков РЭСа
            $z = "UPDATE budget_res 
                  SET "."rq_1"."=".$model->rq_1.
                ',rq_2='.$model->rq_2.
                ',rq_3='.$model->rq_3.
                ',rq_4='.$model->rq_4.
                ',rq_5='.$model->rq_5.
                ',rq_6='.$model->rq_6.
                ',rq_7='.$model->rq_7.
                ',rq_8='.$model->rq_8.
                ',rq_9='.$model->rq_9.
                ',rq_10='.$model->rq_10.
                ',rq_11='.$model->rq_11.
                ',rq_12='.$model->rq_12.

                ',oq_1='.$model->oq_1.
                ',oq_2='.$model->oq_2.
                ',oq_3='.$model->oq_3.
                ',oq_4='.$model->oq_4.
                ',oq_5='.$model->oq_5.
                ',oq_6='.$model->oq_6.
                ',oq_7='.$model->oq_7.
                ',oq_8='.$model->oq_8.
                ',oq_9='.$model->oq_9.
                ',oq_10='.$model->oq_10.
                ',oq_11='.$model->oq_11.
                ',oq_12='.$model->oq_12.

                ',rp_1='.$model->rp_1.
                ',rp_2='.$model->rp_2.
                ',rp_3='.$model->rp_3.
                ',rp_4='.$model->rp_4.
                ',rp_5='.$model->rp_5.
                ',rp_6='.$model->rp_6.
                ',rp_7='.$model->rp_7.
                ',rp_8='.$model->rp_8.
                ',rp_9='.$model->rp_9.
                ',rp_10='.$model->rp_10.
                ',rp_11='.$model->rp_11.
                ',rp_12='.$model->rp_12.

                ',up_1='.$model->up_1.
                ',up_2='.$model->up_2.
                ',up_3='.$model->up_3.
                ',up_4='.$model->up_4.
                ',up_5='.$model->up_5.
                ',up_6='.$model->up_6.
                ',up_7='.$model->up_7.
                ',up_8='.$model->up_8.
                ',up_9='.$model->up_9.
                ',up_10='.$model->up_10.
                ',up_11='.$model->up_11.
                ',up_12='.$model->up_12.
                " WHERE id_budget = ".$model->id;

                Yii::$app->db->createCommand($z)->execute();

            if($mod=='budget')
                $this->redirect(['site/budget','sql' => $sql]);

        } else {
            if($mod=='budget')
                return $this->render('update_budget', [
                    'model' => $model
                ]);
        }
    }

    // Подгрузка групп товаров - происходит при выборе подразделения
    public function actionGetgrups($res) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $mrem = rem::find()->where('ID=:id', [':id' => $res])->all();
            $nazv_rem = trim($mrem[0]->rem);
            $sql = 'select 0 as ID,"0::Всі групи" as grp 
                    union
                    select max(b.ID) as ID,concat(max(b.ID),"::",a.grupa,"  (",count(a.grupa),")") as grp
                         from vw_tovar a
                         inner join vw_tgroup b on 
                         trim(a.grupa)=trim(b.grup)
                         where trim(a.rem)='."'".$nazv_rem."'".
                         ' group by a.grupa';

            $gr = tovar::findBySql($sql)->asArray()->all();
           // debug($gr);
            return ['success' => true, 'gr' => $gr];
        }
        return ['oh no' => 'you are not allowed :('];
    }

    //    Страница о программе
    public function actionAbout()
    {
        $model = new info();
        $model->title = 'Про сайт';
        $model->info1 = "За допомогою цього сайту здійснюється контроль виконання бюджету Центральної Енергетичної Компанії, відповідно заданим параметрам пошуку.";
        $model->style1 = "d15";
        $model->style2 = "info-text";
        $model->style_title = "d9";

        return $this->render('about', [
            'model' => $model]);
    }

    // Добавление строки в бюджет
    public function actionAddrec($sql){
        $model = new addrec();
        $model->isNewRecord=1;
        if ($model->load(Yii::$app->request->post())) {
//            debug($model);
//            return;
            $session = Yii::$app->session;
            if($session->has('user')) {
                $service1 = $session->get('user');
                $service = service::find()->select(['id'])->where('service=:service',[':service' => $service1])->all();
                $service = $service[0]->id;

            }
            else {
                $service = 0;
                $service1 = '';
            }

            $edizm = spr_edizm::find()->select(['ed_izm'])->where('id=:id',[':id' => $model->ed_izm])->all();
            $edizm1 = $edizm[0]->ed_izm;
            $name_spec = spr_spec::find()->select(['name_spec'])->where('id=:id',[':id' => $model->spec])->all();
            $name_spec1 = $name_spec[0]->name_spec;
            $vid_repair = spr_typerepair::find()->select(['vid_repair'])->where('id=:id',[':id' => $model->vid_repair])->all();
            $vid_repair1 = $vid_repair[0]->vid_repair;
            $spr_obj = spr_obj::find()->select(['name_obj'])->where('id=:id',[':id' => $model->name_obj])->all();
            $name_obj1 = $spr_obj[0]->name_obj;
            $page = spr_page::find()->select(['page'])->where('id=:id',[':id' => $model->page])->all();
            $page1 = $page[0]->page;
            $typetmc = spr_typetmc::find()->select(['typetmc'])->where('id=:id',[':id' => $model->typetmc])->all();
            $typetmc1 = $typetmc[0]->typetmc;

            $budget = new budget();
            $z='select max(id) as id from budget';
            $maxid = budget::findbysql($z)->all();
            $maxid = ($maxid[0]->id)+1;

            $budget->type_act = $model->type_act;
            $budget->vid_tmc = $model->typetmc;
            $budget->page = $model->page;
            $budget->name_obj = $model->name_obj;
            $budget->dname_obj = $model->dname_obj;
            $budget->vid_repair = $model->vid_repair;
            $budget->name_spec = $model->spec;
            $budget->ed_izm = $model->ed_izm;
            $budget->price = $model->price;
            $budget->name_tmc = $model->name_tmc;
            $budget->service = $service;
            $budget->service1 = $service1;
            $budget->ed_izm1 = $edizm1;
            $budget->name_spec1 = $name_spec1;
            $budget->vid_repair1 = $vid_repair1;
            $budget->name_obj1 = $name_obj1;
            $budget->page1 = $page1;
            $budget->vid_tmc1 = $typetmc1;
            $budget->id = $maxid;
            $budget->id_zakaz = 1;
            $budget->save();

            $budget_res = new budget_res();
            $z='select max(id) as id from budget_res';
            $maxid_res = budget_res::findbysql($z)->all();
            $maxid_res = $maxid_res[0]->id;
            $budget_res->id_budget = $maxid;
            $budget_res->id = $maxid_res;
            $budget_res->save();


            return $this->redirect(['site/view_budget','sql' => $sql]);
        }
        else{
            return $this->render('addrec', [
                'model' => $model
            ]);
        }
    }


// Аналитика по данным остатков
    public function actionAnalytics_ost()
    {   $src = Yii::$app->request->post('sql');
//        debug('src='.$src);
//        return;
        $model = new analytics_ost();
        if ($model->load(Yii::$app->request->post())){
            $src = $model->src;
            //debug('src='.$src);
            if($model->ord=='error') {echo 'Введіть поле групування!'; return;}
            // Генерация SQL-запроса

            if(empty($model->gr_name_service) || is_null($model->gr_name_service))
                $k1=0;
            else
                $k1=1;

            if(empty($model->gr_type_act) || is_null($model->gr_type_act))
                $k2=0;
            else
                $k2=1;

            if(empty($model->gr_type_tmc) || is_null($model->gr_type_tmc))
                $k3=0;
            else
                $k3=1;

            if(empty($model->gr_type_repair) || is_null($model->gr_type_repair))
                $k4=0;
            else
                $k4=1;

            if(empty($model->gr_page_b) || is_null($model->gr_page_b))
                $k5=0;
            else
                $k5=1;


            if(empty($model->gr_spec) || is_null($model->gr_spec))
                $k6=0;
            else
                $k6=1;

            if(empty($model->gr_obj) || is_null($model->gr_obj))
                $k7=0;
            else
                $k7=1;

            if(empty($model->gr_name_tmc) || is_null($model->gr_name_tmc))
                $k8=0;
            else
                $k8=1;

            if(empty($model->gr_edizm) || is_null($model->gr_edizm))
                $k9=0;
            else
                $k9=1;
            if(empty($model->gr_n_cnt) || is_null($model->gr_n_cnt))
                $k10=0;
            else
                $k10=1;


            if(empty($model->gr_cagent) || is_null($model->gr_cagent))
                $k11=0;
            else
                $k11=1;

            if(empty($model->gra_nakop_q) || is_null($model->gra_nakop_q) || $model->gra_nakop_q=='')
                $ka1=0;
            else
                $ka1=1;

            if(empty($model->gra_nakop_p) || is_null($model->gra_nakop_p))
                $ka2=0;
            else
                $ka2=1;

            if(empty($model->gra_nakop) || is_null($model->gra_nakop))
                $ka3=0;
            else
                $ka3=1;

            if(empty($model->gra_nakop_s) || is_null($model->gra_nakop_s))
                $ka4=0;
            else
                $ka4=1;

            if(empty($model->gra_nakop_o) || is_null($model->gra_nakop_o))
                $ka5=0;
            else
                $ka5=1;

            if(empty($model->gra_nakop_n) || is_null($model->gra_nakop_n))
                $ka6=0;
            else
                $ka6=1;

            if(empty($model->gra_nakop_z) || is_null($model->gra_nakop_z))
                $ka7=0;
            else
                $ka7=1;

            if(empty($model->gra_nakop_x) || is_null($model->gra_nakop_x))
                $ka8=0;
            else
                $ka8=1;
            if(empty($model->gra_nakop_v) || is_null($model->gra_nakop_v))
                $ka9=0;
            else
                $ka9=1;
            if(empty($model->gra_nakop_y) || is_null($model->gra_nakop_y))
                $ka10=0;
            else
                $ka10=1;


            if(empty($model->grh_having) || is_null($model->grh_having))
                $kh1=0;
            else
                $kh1=1;


            $kr=$k1+$k2+$k3+$k4+$k5+$k6+$k7+$k8+$k9+$k10+$k11+$ka1+$ka2+$ka3+$ka4+$ka5+$ka6+$ka7+$ka8+$ka9+$ka10+$kh1;
            //debug('ord='.$model->ord);
            if($kr==0)
                $select = 'select * from ('.$src.') as q';
            else{
                $select='';
                $select1='';
                $select2='';
//                debug($model->ord);
//                return;

                if(($k1+$k2+$k3+$k4+$k5+$k6+$k7+$k8+$k9+$k10+$k11)>=1){

                    $mas=explode(" ",$model->ord);
                    $gr='';
                    foreach($mas as $v){
                        $gr.=substr($v,3).',';
                    }
                    $gr=substr($gr,1,strlen($gr));
                    $select=$gr;


                }

//                debug($select);
//                return;

                if(($ka1+$ka2+$ka3+$ka4+$ka5+$ka6+$ka7+$ka8+$ka9+$ka10)>=1){

                    if($model->gra_oper==1) $o='SUM(';
                    if($model->gra_oper==2) $o='MAX(';
                    if($model->gra_oper==3) $o='MIN(';
                    if($model->gra_oper==4) $o='AVG(';
                    if($model->gra_oper==5) $o='COUNT(';
                    if($ka1==1) {
                        $select1.=$o.'nakop_q'.') as nakop_q'.',';
                        $select2.=$o.'nakop_q'.')';

                    }
                    if($ka2==1){
                        $select1.=$o.'nakop_p'.') as nakop_p'.',';
                        $select2.=$o.'nakop_p'.')';
                    }
                    if($ka3==1){
                        $select1.=$o.'nakop'.') as nakop'.',';
                        $select2.=$o.'nakop'.')';
                    }
                    if($ka4==1){
                        $select1.=$o.'nakop_s'.') as nakop_s'.',';
                        $select2.=$o.'nakop_s'.')';
                    }
                    if($ka5==1){
                        $select1.=$o.'nakop_o'.') as nakop_o'.',';
                        $select2.=$o.'nakop_o'.')';
                    }
                    if($ka6==1){
                        $select1.=$o.'nakop_n'.') as nakop_n'.',';
                        $select2.=$o.'nakop_n'.')';
                    }
                    if($ka7==1){
                        $select1.=$o.'nakop_z'.') as nakop_z'.',';
                        $select2.=$o.'nakop_z'.')';
                    }
                    if($ka8==1){
                        $select1.=$o.'nakop_x'.') as nakop_x'.',';
                        $select2.=$o.'nakop_x'.')';
                    }
                    if($ka9==1){
                        $select1.=$o.'nakop_v'.') as nakop_v'.',';
                        $select2.=$o.'nakop_v'.')';
                    }
                    if($ka10==1){
                        $select1.=$o.'nakop_y'.') as nakop_y'.',';
                        $select2.=$o.'nakop_y'.')';
                    }
                    $select1=substr($select1,0,strlen($select1)-1);

//                    debug($select1);
//                    return;

                }

                if($model->gra_oper==5){
                    $select1='COUNT(*) as kol';

                }
                if(!empty($select1))
                    $select = 'select '.$select.$select1.' from ('.$src.') as q';
                else
                    $select = 'select '.$select.' from ('.$src.') as q';
            }
            $sql='';

//            debug($select);
//            return;

            // WHERE

//            if(!empty($model->res)){
//                $res=spr_res::findbysql(
//                    "select nazv from spr_res where "
//                    . 'id=:id ',[':id' => $model->res])->all();
//                $sql.=' and res='."'".$res[0]->nazv."'";
//            }
//            if(!empty($model->status))
//                $sql.=' and status='.$model->status;
//            if(trim($model->work)=='style="font-size:') $model->work='';
//            if(!empty($model->work) && !is_null($model->work)){
//                $work = spr_costwork::findbysql('Select work from costwork where '
//                    . 'id=:id ',[':id' => $model->work])
//                    ->all();
//
//                $sql.=' and usluga='."'".$work[0]->work."'";
//            }
//            if(!empty($model->usluga)){
//                $usl = spr_costwork::findbysql('Select usluga from costwork where '
//                    . 'id=:id ',[':id' => $model->usluga])
//                    ->all();
//                $sql.=' and usl='."'".$usl[0]->usluga."'";
//
//            }
            if(!empty($sql))
                $sql=$select.' where '.mb_substr($sql,4,400,"UTF-8");
            else{
                $sql=$select;
            }

            // Добавляем GROUP BY
            if(!empty($gr)){
                $gr=substr($gr,0,strlen($gr)-1);
                $sql.=' GROUP BY '.$gr;
            }
            // Добавляем HAVING
            $having='';
            $oh='';
            if(!empty($model->grh_having)){
                $kh1=$model->grh_having;
                if(!empty($model->grh_value)){
                    $having = ' HAVING '.$select2;

                    switch ($kh1) {
                        case 1:
                            $oh='=';
                            break;
                        case 2:
                            $oh='>';
                            break;
                        case 3:
                            $oh='>=';
                            break;
                        case 4:
                            $oh='<';
                            break;
                        case 5:
                            $oh='<=';
                            break;
                        case 6:
                            $oh='<>';
                            break;

                    }
                    $having.=$oh.$model->grh_value;
                    $sql.=$having;
                }
            }
            // Добавляем ORDER BY
            $orderby='';
            $oo='';
            if(!empty($model->grs_sort)){
                $ks1=$model->grs_sort;
                switch ($ks1) {
                    case 1:
                        $oo='res';
                        break;
                    case 2:
                        $oo='status_sch';
                        break;
                    case 3:
                        $oo='date';
                        break;
                    case 4:
                        $oo='date_opl';
                        break;
                    case 5:
                        $oo='usl';
                        break;
                    case 6:
                        $oo='usluga';
                        break;
                    case 7:
                        $oo='summa';
                        break;
                    case 8:
                        $oo='summa_beznds';
                        break;
                    case 9:
                        $oo='summa_work';
                        break;
                    case 10:
                        $oo='summa_transport';
                        break;
                    case 11:
                        $oo='summa_delivery';
                        break;

                }
                $orderby = ' ORDER BY '.$oo;
                if(!empty($model->grs_dir)){
                    if($model->grs_dir==2) $orderby.=' DESC ';
                }
                $sql.=$orderby;
            }
//            debug($sql);
//            return;
            $dataProvider = new ActiveDataProvider([
                'query' => view_budget::findBySql($sql),
                'pagination' => [
                    'pageSize' => 500,
                ],
            ]);
            //$dataProvider = viewanalit::findBySql($sql);
            $data = view_budget::findBySql($sql)->all();
            $data1 = view_budget::findBySql($sql)->asarray()->all();
            // Запоминаем sql запрос в сессии
            $session = Yii::$app->session;
            $session->open();
            $session->set('sql_analytics', $sql);

//            debug($sql);
//            return;

            $model->ord = trim($model->ord);
            $q_all = count($data1);
            if(count($data1))
            {    $a = array_keys($data1[0]);
            }
            else {
                echo "Без результату";
                return;
            }

            $file = '../views/site/analytics_res.php';
            $file_src = 'analit_src.php';
            $f = fopen($file,'w');
            $fsrc = fopen($file_src,'r');
            while (!feof($fsrc)) {
                $s=fgets($fsrc);
                fputs($f,$s);
            }
            fclose($fsrc);
            $s='<span class="res-analit1">Всього: </span>'.$q_all;
            fputs($f,$s);
            fputs($f,"<br>");
            fputs($f,"<br>");
            fputs($f,"<br>");
            fputs($f,"<br>");
            $s="<?= GridView::widget([
            'dataProvider' => ".'$dataProvider,'.
                "'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed'],
            'summary' => false,
            'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ";
            fputs($f,$s);
            $a1=[];
            $i=0;
            $pos = strpos($sql, chr(39));
            //debug($pos);
            // return;

//            if ($pos === false)
//                $sql ="'".$sql."'";
//            else
//                $sql ='"'.$sql.'"';

            $sql=str_replace('"',"'",$sql);
            $sql ='"'.$sql.'"';

//            debug($sql);
//            return;
            //'data' => ".'"'.$sql.'"'."
            foreach($a as $v){
                $s="'".$v."',";
                $a1[$i]=$v;
                fputs($f,$s);
                $i++;
            }
            fputs($f,'] ]); ?> ');
            fputs($f,'</div>');
            fputs($f,"<?php echo Html::a('Експорт в Excel', ['site/analytics_ost_excel'
            ],
                ['class' => 'btn btn-info excel_btn',
                'data' => [
                'method' => 'post',
                'params' => [
               
                'data' => $sql
               
            ],
                 ]]); ?>");

            fclose($f);


            return $this->render('analytics_res',['data' => $data,'dataProvider' => $dataProvider,
                'style_title' => 'd9']);
//            return $this->redirect(['site/analytics_res',
//                'sql' => $sql]);

        }
        else {
            return $this->render('analytics_ost',['model' => $model,'style_title' => 'd9','src' => $src]);}
    }


    public function actionAnalytics_res($sql)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => view_budget::findBySql($sql),
            'pagination' => [
                'pageSize' => 500,
            ],
        ]);
        //$dataProvider = viewanalit::findBySql($sql);
        $data = view_budget::findBySql($sql)->all();
//        $data1 = view_budget::findBySql($sql)->asarray()->all();
        // Запоминаем sql запрос в сессии
        $session = Yii::$app->session;
        $session->open();
        $session->set('sql_analytics', $sql);

//            debug($sql);
//            return;

//        $q_all = count($data1);
//        if(count($data1))
//        {    $a = array_keys($data1[0]);
//        }
//        else {
//            echo "Без результату";
//            return;
//        }
        return $this->render('analytics_res',['data' => $data,'dataProvider' => $dataProvider,
                'style_title' => 'd9']);

    }

// Аналитика по данным бюджета
    public function actionAnalytics($sql)
    {   $src = Yii::$app->request->post('sql');
        $src = $sql;
        //debug('src='.$src);
        $model = new analytics();
        if ($model->load(Yii::$app->request->post())){
            $src = $model->src;
            //debug('src='.$src);
            if($model->ord=='error') {echo 'Введіть поле групування!'; return;}
            // Генерация SQL-запроса

            if(empty($model->gr_name_service) || is_null($model->gr_name_service))
                $k1=0;
            else
                $k1=1;

            if(empty($model->gr_type_act) || is_null($model->gr_type_act))
                $k2=0;
            else
                $k2=1;

            if(empty($model->gr_type_tmc) || is_null($model->gr_type_tmc))
                $k3=0;
            else
                $k3=1;

            if(empty($model->gr_type_repair) || is_null($model->gr_type_repair))
                $k4=0;
            else
                $k4=1;

            if(empty($model->gr_page_b) || is_null($model->gr_page_b))
                $k5=0;
            else
                $k5=1;


            if(empty($model->gr_spec) || is_null($model->gr_spec))
                $k6=0;
            else
                $k6=1;

            if(empty($model->gr_obj) || is_null($model->gr_obj))
                $k7=0;
            else
                $k7=1;

            if(empty($model->gr_name_tmc) || is_null($model->gr_name_tmc))
                $k8=0;
            else
                $k8=1;

            if(empty($model->gr_edizm) || is_null($model->gr_edizm))
                $k9=0;
            else
                $k9=1;

            if(empty($model->gra_nakop_q) || is_null($model->gra_nakop_q) || $model->gra_nakop_q=='')
                $ka1=0;
            else
                $ka1=1;

            if(empty($model->gra_nakop_p) || is_null($model->gra_nakop_p))
                $ka2=0;
            else
                $ka2=1;

            if(empty($model->gra_nakop) || is_null($model->gra_nakop))
                $ka3=0;
            else
                $ka3=1;

            if(empty($model->gra_nakop_s) || is_null($model->gra_nakop_s))
                $ka4=0;
            else
                $ka4=1;

            if(empty($model->gra_nakop_o) || is_null($model->gra_nakop_o))
                $ka5=0;
            else
                $ka5=1;

            if(empty($model->gra_nakop_n) || is_null($model->gra_nakop_n))
                $ka6=0;
            else
                $ka6=1;

            if(empty($model->gra_nakop_z) || is_null($model->gra_nakop_z))
                $ka7=0;
            else
                $ka7=1;

            if(empty($model->gra_nakop_x) || is_null($model->gra_nakop_x))
                $ka8=0;
            else
                $ka8=1;


            if(empty($model->grh_having) || is_null($model->grh_having))
                $kh1=0;
            else
                $kh1=1;


            $kr=$k1+$k2+$k3+$k4+$k5+$k6+$k7+$k8+$k9+$ka1+$ka2+$ka3+$ka4+$ka5+$ka6+$ka7+$ka8+$kh1;
            //debug('ord='.$model->ord);
            if($kr==0)
                $select = 'select * from ('.$src.') as q';
            else{
                $select='';
                $select1='';
                $select2='';
                if(($k1+$k2+$k3+$k4+$k5+$k6+$k7+$k8+$k9)>=1){
                    $mas=explode(" ",$model->ord);
                    $gr='';
                    foreach($mas as $v){
                        $gr.=substr($v,3).',';
                    }
                    $gr=substr($gr,1,strlen($gr));
                    $select=$gr;


                }

                if(($ka1+$ka2+$ka3+$ka4+$ka5+$ka6+$ka7+$ka8)>=1){

                    if($model->gra_oper==1) $o='SUM(';
                    if($model->gra_oper==2) $o='MAX(';
                    if($model->gra_oper==3) $o='MIN(';
                    if($model->gra_oper==4) $o='AVG(';
                    if($model->gra_oper==5) $o='COUNT(';
                    if($ka1==1) {
                        $select1.=$o.'nakop_q'.') as nakop_q'.',';
                        $select2.=$o.'nakop_q'.')';

                    }
                    if($ka2==1){
                        $select1.=$o.'nakop_p'.') as nakop_p'.',';
                        $select2.=$o.'nakop_p'.')';
                    }
                    if($ka3==1){
                        $select1.=$o.'nakop'.') as nakop'.',';
                        $select2.=$o.'nakop'.')';
                    }
                    if($ka4==1){
                        $select1.=$o.'nakop_s'.') as nakop_s'.',';
                        $select2.=$o.'nakop_s'.')';
                    }
                    if($ka5==1){
                        $select1.=$o.'nakop_o'.') as nakop_o'.',';
                        $select2.=$o.'nakop_o'.')';
                    }
                    if($ka6==1){
                        $select1.=$o.'nakop_n'.') as nakop_n'.',';
                        $select2.=$o.'nakop_n'.')';
                    }
                    if($ka7==1){
                        $select1.=$o.'nakop_z'.') as nakop_z'.',';
                        $select2.=$o.'nakop_z'.')';
                    }
                    if($ka8==1){
                        $select1.=$o.'nakop_x'.') as nakop_x'.',';
                        $select2.=$o.'nakop_x'.')';
                    }
                    $select1=substr($select1,0,strlen($select1)-1);

                    //debug($select);

                }

                if($model->gra_oper==5){
                    $select1='COUNT(*) as kol';

                }
                if(!empty($select1))
                    $select = 'select '.$select.$select1.' from ('.$src.') as q';
                else
                    $select = 'select '.$select.' from ('.$src.') as q';
            }
            $sql='';
            // WHERE

//            if(!empty($model->res)){
//                $res=spr_res::findbysql(
//                    "select nazv from spr_res where "
//                    . 'id=:id ',[':id' => $model->res])->all();
//                $sql.=' and res='."'".$res[0]->nazv."'";
//            }
//            if(!empty($model->status))
//                $sql.=' and status='.$model->status;
//            if(trim($model->work)=='style="font-size:') $model->work='';
//            if(!empty($model->work) && !is_null($model->work)){
//                $work = spr_costwork::findbysql('Select work from costwork where '
//                    . 'id=:id ',[':id' => $model->work])
//                    ->all();
//
//                $sql.=' and usluga='."'".$work[0]->work."'";
//            }
//            if(!empty($model->usluga)){
//                $usl = spr_costwork::findbysql('Select usluga from costwork where '
//                    . 'id=:id ',[':id' => $model->usluga])
//                    ->all();
//                $sql.=' and usl='."'".$usl[0]->usluga."'";
//
//            }
            if(!empty($sql))
                $sql=$select.' where '.mb_substr($sql,4,400,"UTF-8");
            else{
                $sql=$select;
            }

            // Добавляем GROUP BY
            if(!empty($gr)){
                $gr=substr($gr,0,strlen($gr)-1);
                $sql.=' GROUP BY '.$gr;
            }
            // Добавляем HAVING
            $having='';
            $oh='';
            if(!empty($model->grh_having)){
                $kh1=$model->grh_having;
                if(!empty($model->grh_value)){
                    $having = ' HAVING '.$select2;

                    switch ($kh1) {
                        case 1:
                            $oh='=';
                            break;
                        case 2:
                            $oh='>';
                            break;
                        case 3:
                            $oh='>=';
                            break;
                        case 4:
                            $oh='<';
                            break;
                        case 5:
                            $oh='<=';
                            break;
                        case 6:
                            $oh='<>';
                            break;

                    }
                    $having.=$oh.$model->grh_value;
                    $sql.=$having;
                }
            }
            // Добавляем ORDER BY
            $orderby='';
            $oo='';
            if(!empty($model->grs_sort)){
                $ks1=$model->grs_sort;
                switch ($ks1) {
                    case 1:
                        $oo='res';
                        break;
                    case 2:
                        $oo='status_sch';
                        break;
                    case 3:
                        $oo='date';
                        break;
                    case 4:
                        $oo='date_opl';
                        break;
                    case 5:
                        $oo='usl';
                        break;
                    case 6:
                        $oo='usluga';
                        break;
                    case 7:
                        $oo='summa';
                        break;
                    case 8:
                        $oo='summa_beznds';
                        break;
                    case 9:
                        $oo='summa_work';
                        break;
                    case 10:
                        $oo='summa_transport';
                        break;
                    case 11:
                        $oo='summa_delivery';
                        break;

                }
                $orderby = ' ORDER BY '.$oo;
                if(!empty($model->grs_dir)){
                    if($model->grs_dir==2) $orderby.=' DESC ';
                }
                $sql.=$orderby;
            }
//            debug($sql);
//            return;
            $dataProvider = new ActiveDataProvider([
                'query' => view_budget::findBySql($sql),
                'pagination' => [
                    'pageSize' => 500,
                ],
            ]);
            //$dataProvider = viewanalit::findBySql($sql);
            $data = view_budget::findBySql($sql)->all();
            $data1 = view_budget::findBySql($sql)->asarray()->all();
            // Запоминаем sql запрос в сессии
            $session = Yii::$app->session;
            $session->open();
            $session->set('sql_analytics', $sql);

//            debug($sql);
//            return;

            $model->ord = trim($model->ord);
            $q_all = count($data1);
            if(count($data1))
            {    $a = array_keys($data1[0]);
            }
            else {
                echo "Без результату";
                return;
            }

            $file = '../views/site/analytics_res.php';
            $file_src = 'analit_src.php';
            $f = fopen($file,'w');
            $fsrc = fopen($file_src,'r');
            while (!feof($fsrc)) {
                $s=fgets($fsrc);
                fputs($f,$s);
            }
            fclose($fsrc);
            $s='<span class="res-analit1">Всього: </span>'.$q_all;
            fputs($f,$s);
            fputs($f,"<br>");
            fputs($f,"<br>");
            fputs($f,"<br>");
            fputs($f,"<br>");
            $s="<?= GridView::widget([
            'dataProvider' => ".'$dataProvider,'.
                "'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed'],
            'summary' => false,
            'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ";
            fputs($f,$s);
            $a1=[];
            $i=0;
            $pos = strpos($sql, chr(39));
            //debug($pos);
            // return;

//            if ($pos === false)
//                $sql ="'".$sql."'";
//            else
//                $sql ='"'.$sql.'"';
            $sql=str_replace('"',"'",$sql);
            $sql ='"'.$sql.'"';

//            debug($sql);
//            return;
            //'data' => ".'"'.$sql.'"'."
            foreach($a as $v){
                $s="'".$v."',";
                $a1[$i]=$v;
                fputs($f,$s);
                $i++;
            }
            fputs($f,'] ]); ?> ');
            fputs($f,'</div>');
            fputs($f,"<?php echo Html::a('Експорт в Excel', ['site/analytics_excel'
            ],
                ['class' => 'btn btn-info excel_btn',
                'data' => [
                'method' => 'post',
                'params' => [
               
                'data' => $sql
               
            ],
                 ]]); ?>");

            fclose($f);


            return $this->render('analytics_res',['data' => $data,'dataProvider' => $dataProvider,
                'style_title' => 'd9']);

        }
        else {
            return $this->render('analytics',['model' => $model,'style_title' => 'd9','src' => $src]);}
    }

    // Сброс аналитики в Excel
    public function actionAnalytics_excel()
    {
        $sql=Yii::$app->request->post('data');
        $model = view_budget::findBySql($sql)->asarray()->all();
        $dataProvider = new ActiveDataProvider([
            'query' => view_budget::findBySql($sql),
            'pagination' => [
                'pageSize' => 500,
            ],
        ]);
        $session = Yii::$app->session;
        if($session->has('sql_analytics'))
            $sql = $session->get('sql_analytics');
        else
            $sql='';


        $cols = [
            'name_service' => 'Підрозділ:',
            'name_tmc' => 'Назва ТМЦ',
            'spec' => 'Розділ закупівель',
            'page_b' => 'Стаття бюджету',
            'type_repair' => 'Вид ремонту',
            'type_act' => 'Тип діяльності',
            'type_tmc' => 'Вид ТМЦ',
            'obj' => 'Назва обʼєкту',
            'edizm' => 'Од.вим.',
            'nakop' => 'підсумок отримано,кільк.',
            'nakop_q' => 'підсумок замовлено,кільк.',
            'nakop_n' => 'підсумок не використ.,кільк.',
            'nakop_o' => 'підсумок списано,кільк.',
            'nakop_s' => 'підсумок отримано,варт.',
            'nakop_p' => 'підсумок замовлено,варт.',
            'nakop_x' => 'підсумок не отримано.,варт',
            'nakop_z' => 'підсумок не отримано.,кільк',
        ];

        // Формирование массива названий колонок
        $list='';  // Список полей для сброса в Excel
        $h=[];
        $i=0;
//        debug($model);
//        return;
        $j=0;
        $col_e=[];
        foreach($model[0] as $k=>$v){
            $col="'".$k."'";
            $col_e[$j]=$k;
            $j++;
            if(in_array(trim($k), array_keys($cols), true)){
                $h[$i]['col']=$col;
                $i++;
            }
        }

//        debug($cols);
//        return;

        $k1='Результат аналітики';

        $newQuery = clone $dataProvider->query;
        $models = $newQuery->all();

        \moonland\phpexcel\Excel::widget([
            'models' => $models,

            'mode' => 'export', //default value as 'export'
            'format' => 'Excel2007',
            'hap' => $k1,    //cтрока шапки таблицы
            'data_model' => 1,
            //'columns' => $h,
            'columns' => $col_e,
            'headers' => $cols
        ]);
        return;

    }

    // Сброс аналитики в Excel
    public function actionAnalytics_ost_excel()
    {
        $sql=Yii::$app->request->post('data');
        $model = view_budget::findBySql($sql)->asarray()->all();
        $dataProvider = new ActiveDataProvider([
            'query' => view_budget::findBySql($sql),
            'pagination' => [
                'pageSize' => 500,
            ],
        ]);
        $session = Yii::$app->session;
        if($session->has('sql_analytics'))
            $sql = $session->get('sql_analytics');
        else
            $sql='';


        $cols = [
            'name_service' => 'Підрозділ:',
            'name_tmc' => 'Назва ТМЦ',
            'spec' => 'Розділ закупівель',
            'page_b' => 'Стаття бюджету',
            'type_repair' => 'Вид ремонту',
            'type_act' => 'Тип діяльності',
            'type_tmc' => 'Вид ТМЦ',
            'obj' => 'Назва обʼєкту',
            'edizm' => 'Од.вим.',
            'nakop' => 'підсумок отримано,кільк.',
            'nakop_q' => 'підсумок замовлено,кільк.',
            'nakop_n' => 'підсумок не використ.,кільк.',
            'nakop_o' => 'підсумок списано,кільк.',
            'nakop_s' => 'підсумок отримано,варт.',
            'nakop_p' => 'підсумок замовлено,варт.',
            'nakop_x' => 'підсумок не отримано.,варт',
            'nakop_z' => 'підсумок не отримано.,кільк',
            'nakop_y' => 'підсумок не отримано. факт,кільк',
            'nakop_v' => 'підсумок видано РЕМ. факт,кільк',
        ];

        // Формирование массива названий колонок
        $list='';  // Список полей для сброса в Excel
        $h=[];
        $i=0;
//        debug($model);
//        return;
        $j=0;
        $col_e=[];
        foreach($model[0] as $k=>$v){
            $col="'".$k."'";
            $col_e[$j]=$k;
            $j++;
            if(in_array(trim($k), array_keys($cols), true)){
                $h[$i]['col']=$col;
                $i++;
            }
        }


        $k1='Результат аналітики';

        $newQuery = clone $dataProvider->query;
        $models = $newQuery->all();

        \moonland\phpexcel\Excel::widget([
            'models' => $models,

            'mode' => 'export', //default value as 'export'
            'format' => 'Excel2007',
            'hap' => $k1,    //cтрока шапки таблицы
            'data_model' => 1,
            //'columns' => $h,
            'columns' => $col_e,
            'headers' => $cols
        ]);
        return;

    }



// Добавление новых пользователей
    public function actionAddAdmin() {
        $model = User::find()->where(['username' => 'user22'])->one();
        if (empty($model)) {
            $user = new User();
            $user->username = 'user22';
            $user->email = 'user22@ukr.net';
            $user->setPassword('elfxf');
            $user->generateAuthKey();
            if ($user->save()) {
                echo 'good';
            }
        }
    }

// Выход пользователя
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['site/cek']);

    }


}
