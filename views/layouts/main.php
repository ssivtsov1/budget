<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;
use yii\web\Request;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
//$this->registerJsFile(
//    '@web/js/func_js.js',
//    ['depends' => [\yii\web\JqueryAsset::className()]]
//);
?>
<?php $this->beginPage();
$this->title = 'Бюджет';
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--    <script>src="https://unpkg.com/sticky-table-headers"></script>-->
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php

         $this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => Url::to(['/favicon.ico'])]);

        $flag=1;
        $role=0;
        $main=0;
        $user='';
        $user_id=0;
        $department = '';
        $view=0;
        if(!isset(Yii::$app->user->identity->role))
        {      $flag=0;}
        else {
            $role = Yii::$app->user->identity->role;
            $user = Yii::$app->user->identity->department;
            $user_id = Yii::$app->user->identity->id_res;
        }


       // die;
        if(isset(Yii::$app->user->identity->role)) {
                $adm = Yii::$app->user->identity->role;
                if ($adm==3)
                {
                    $main=1;
                    $this->params['admin'][] = "Режим адміністратора: ";
                    $user = Yii::$app->user->identity->department;
                    $user_id = Yii::$app->user->identity->id_res;
                }
                else
                    $this->params['admin'][] = "Режим користувача: ";
         }

        if(isset(Yii::$app->user->identity->department))
          $department=Yii::$app->user->identity->department;
        else
            $department='гость';

        if(!isset(Yii::$app->user->identity->role))
            $main=2;
      
        if($main!=1)    
        NavBar::begin([
                'brandLabel' => 'Бюджет',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    //'class' => 'navbar-inverse navbar-fixed-top',
                    'class' => 'navbar-default navbar-fixed-top',
                    
                ],
            ]);
        else
          NavBar::begin([
                'brandLabel' => 'Бюджет (режим адміністратора)',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    //'class' => 'navbar-inverse navbar-fixed-top',
                    'class' => 'navbar-default navbar-fixed-top',
                    
                ],
            ]);  


       
            if($department<>'гость')
            switch ($main) {

            case 1:
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-right'],
                    'items' => [
                        ['label' => Html::tag('span',' Головна',['class' => 'glyphicon glyphicon-home']) ,
                            'url' => ['/site/index']],
                        
                        //['label' => 'Плани', 'url' => ['/site/plans']],
                        ['label' => 'Бюджет', 'url'=> ['/site/budget']],
                        ['label' => 'Залишки товару', 'url'=> ['/site/ost']],
//                        ['label' => 'Довідники', 'url' => ['/site/index'],
//                            'options' => ['id' => 'down_menu'],
//                            'items' => [
//                                ['label' => 'Довідник моїх проектів', 'url' => ['/sprav/sprav_project']],
//                            ]],
                        ['label' => 'Про сайт', 'url' => ['/site/about']],
                        ['label' => Html::tag('span',' Вийти',['class' => 'glyphicon glyphicon-log-out']),
                             'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
                        
                    ],
                    'encodeLabels' => false,
                ]);
                break;
            case 0:
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-right'],
                    'items' => [
                        ['label' => Html::tag('span',' Головна',['class' => 'glyphicon glyphicon-home']) ,
                            'url' => ['/site/index']],

                        //['label' => 'Плани', 'url' => ['/site/plans']],
                        ['label' => 'Бюджет', 'url'=> ['/site/budget']],
                        ['label' => 'Залишки товару', 'url'=> ['/site/ost']],
//                        ['label' => 'Довідники', 'url' => ['/site/index'],
//                            'options' => ['id' => 'down_menu'],
//                            'items' => [
//                                ['label' => 'Довідник моїх проектів', 'url' => ['/sprav/sprav_project']],
//                            ]],
                        ['label' => 'Про сайт', 'url' => ['/site/about']],
                        ['label' => Html::tag('span',' Вийти',['class' => 'glyphicon glyphicon-log-out']),
                            'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],

                    ],
                    'encodeLabels' => false,
                ]);
                break;
            case 2:
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-right'],
                    'items' => [
                        ['label' => Html::tag('span',' Головна',['class' => 'glyphicon glyphicon-home']) ,
                            'url' => ['/site/index']],

                        //['label' => 'Плани', 'url' => ['/site/plans']],
                        ['label' => 'Бюджет', 'url'=> ['/site/budget']],
                        ['label' => 'Залишки товару', 'url'=> ['/site/ost']],
//                        ['label' => 'Довідники', 'url' => ['/site/index'],
//                            'options' => ['id' => 'down_menu'],
//                            'items' => [
//                                ['label' => 'Довідник моїх проектів', 'url' => ['/sprav/sprav_project']],
//                            ]],
                        ['label' => 'Про сайт', 'url' => ['/site/about']],
                        ['label' => Html::tag('span',' Вийти',['class' => 'glyphicon glyphicon-log-out']),
                            'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],

                    ],
                    'encodeLabels' => false,
                ]);
                break;
        }
            NavBar::end();
        ?>


        <!--Вывод логотипа-->
        <?php
        //echo Yii::$app->getRequest()->getBaseUrl(true);
        $session = Yii::$app->session;
        $session->open();
        $session->set('user',$user);
        $session->set('user_id',$user_id);
        if($session->has('view'))
            $view = $session->get('view');
        else
            $view = 0;
        if(!$view){
        ?>
        <? if(!strpos(Yii::$app->request->url,'/cek')): ?>
       
        <? if(strlen(Yii::$app->request->url)==10): ?>
<!--        <img class="logo_site" src="web/Logo.png" alt="ЦЕК" />-->
        <? endif; ?>

        <? if(strlen(Yii::$app->request->url)<>10): ?>
<!--            <img class="logo_site" src="../Logo.png" alt="ЦЕК" />-->
        <? endif; ?>
        <? endif; ?>

        <? if(strpos(Yii::$app->request->url,'/cek')): ?>
            <? if(strlen(Yii::$app->request->url)==10): ?>
<!--                <img class="logo_site" src="web/Logo.png" alt="ЦЕК" />-->
            <? endif; ?>

            <? if(strlen(Yii::$app->request->url)<>10): ?>
<!--                <img class="logo_site" src="../Logo.png" alt="ЦЕК" />-->
            <? endif; ?>
        <? endif; }?>


        <div class="container">

            <div class="page-header">
                <small class="text-info">
                    <?php
                   
                    if(isset($this->params['admin'] ))
                        if(isset($this->params['res'] ))
                        //echo $this->params['admin'][0] . ' '. $this->params['res'][0];
                           // echo $main;
                    ?>
                    </small>

            </div>

            <div class="page-header">
                <small class="text-info">Ви зайшли як: <mark><?php echo $department; ?></mark> </small></h1>
            </div>

            <?= Breadcrumbs::widget([
                'homeLink' => ['label' => 'Головна', 'url' => '/info'],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
             
            <?= $content ?>
            
            
            
        </div>
        <section class="hero_area">
        </section>  

    </div>
 
    <footer class="footer">
        
        <div id="container_footer" class="container">
            <p class="pull-left">&copy; ЦЕК <?= date('Y') ?> &nbsp &nbsp
            <?= Html::a('Головна',["index"],['class' => 'a_main']); ?> &nbsp &nbsp
            <?= Html::a("<a class='a_main' href='http://cek.dp.ua'>сайт ПрАТ ПЕЕМ ЦЕК</a>"); ?>
            </p>
            <p class="pull-right">
            <img class='footer_img' src="../Logo.png">
            </p>
            <?php
                $day = date('j');
                $month = date('n');
                $day_week = date('w');
                switch ($day_week)  {
                    case 0: 
                        $dw = 'нед.';
                        break;
                    case 1: 
                        $dw = 'пон.';
                        break;
                    case 2: 
                        $dw = 'вівт.';
                        break;
                    case 3: 
                        $dw = 'середа';
                        break;
                    case 4: 
                        $dw = 'четв.';
                        break;
                    case 5: 
                        $dw = 'п’ятн.';
                        break;
                    case 6: 
                        $dw = 'суб.';
                        break;
                    
                }    
                $day = $day.' '.$dw;
            ?>
            
            <table width="100%" class="table table-condensed" id="calendar_footer">
            <tr>
                <th width="8.33%">
                    <?php
                    if($month==1) echo '<div id="on_ceil">'.$day.'</div>';
                    ?>
                   
                </th> 
                <th width="8.33%">
                    <?php
                    if($month==2) echo '<div id="on_ceil">'.$day.'</div>';
                    ?>
                </th> 
                <th width="8.33%">
                   <?php
                    if($month==3) echo '<div id="on_ceil">'.$day.'</div>';
                    ?>
                </th> 
                <th width="8.33%">
                    <?php
                    if($month==4) echo '<div id="on_ceil">'.$day.'</div>';
                    ?>
                </th>
                <th width="8.33%">
                    <?php
                    if($month==5) echo '<div id="on_ceil">'.$day.'</div>';
                    ?>
                </th>
                <th width="8.33%">
                    <?php
                    if($month==6) echo '<div id="on_ceil">'.$day.'</div>';
                    ?>
                </th>
                <th width="8.33%">
                    <?php
                    if($month==7) echo '<div id="on_ceil">'.$day.'</div>';
                    ?>
                </th>
                <th width="8.33%">
                    <?php
                    if($month==8) echo '<div id="on_ceil">'.$day.'</div>';
                    ?>
                </th>
                <th width="8.33%">
                    <?php
                    if($month==9) echo '<div id="on_ceil">'.$day.'</div>';
                    ?>
                </th>
                <th width="8.33%">
                     <?php
                    if($month==10) echo '<div id="on_ceil">'.$day.'</div>';
                    ?>
                </th>
                <th width="8.33%">
                     <?php
                    if($month==11) echo '<div id="on_ceil">'.$day.'</div>';
                    ?>
                </th>
                <th width="8.33%">
                     <?php
                    if($month==12) echo '<div id="on_ceil">'.$day.'</div>';
                    ?>
                </th>
                </tr>
                <tr>
                    
                <td>   
                     <?= Html::encode("січень") ?>
                </td> 
                <td>
                     <?= Html::encode("лютий") ?>
                </td> 
                <td>
                     <?= Html::encode("березень") ?>
                </td> 
                <td>
                     <?= Html::encode("квітень") ?>
                </td>
                <td>
                     <?= Html::encode("травень") ?>
                </td>
                <td>
                     <?= Html::encode("червень") ?>
                </td>
                <td>
                     <?= Html::encode("липень") ?>
                </td>
                <td>
                     <?= Html::encode("серпень") ?>
                </td>
                <td>
                     <?= Html::encode("вересень") ?>
                </td>
                <td>
                     <?= Html::encode("жовтень") ?>
                </td>
                <td >
                     <?= Html::encode("листопад") ?>
                </td>
                <td>
                     <?= Html::encode("грудень") ?>
                </td>
               </tr>

                
            </table>  
            
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
