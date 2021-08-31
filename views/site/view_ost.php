<script>

   window.addEventListener('load', function () {
       // Фиксация шапки при вертикальном скроллинге
       var tableOffset = $(".table").offset().top;
       var $header = $(".table > thead").clone();
       var $body = $(".table > tbody").clone();
       var $fixedHeader = $("#header-fixed-ost").append($header);
       $("#header-fixed-ost").width($(".table").width());

       $(window).bind("scroll", function() {
           var offset = $(this).scrollTop();

           if (offset >= tableOffset && $fixedHeader.is(":hidden")) {

               $fixedHeader.show();
           }
           else if (offset < tableOffset) {
               $fixedHeader.hide();
           }

           $("#header-fixed-ost th").each(function(index){
               var index2 = index;
               $(this).width(function(index2){
                   return $(".table th").eq(index).width();
               });
           });
       });
   });

</script>

<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\SerialColumn;
use yii\helpers\ArrayHelper;
use app\models\projects;
use app\models\status;
use app\models\diary;

$this->title = 'Бюджет';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-spr">

    <h4><?php

        echo Html::encode($this->title.'. Всього знайдено: '.$kol);
    ?></h4>
    <script>
        var kol = <?php echo $kol; ?>
    </script>

    <?= Html::a(' Пошук', ['ost'], ['class' => 'btn btn-success glyphicon glyphicon-search']);
    echo '<span> &nbsp </span>';
    echo Html::a('Аналітика ', ['site/analytics_ost'],[
        'data' => [
            'method' => 'post',
            'params' => [
                'sql' => $sql,

            ],],
        'class' => 'btn glyphicon glyphicon-stats btn-info']);
        echo '<br>';
        echo '<br>';
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'summary' => false,
        'emptyText' => 'Нічого не знайдено',
//        'tableOptions' => ['class' => 'table table-striped table-bordered table-fixed'],
        'rowOptions' => function ($model) {
            //add your condition here
            if ($model->id == 1 || $model->id == 2 || $model->id == 3  ) {
                return ['style' => ' position:fixed;'];
            }
        },
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],

        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            ['attribute' =>'spec',
                'label' => "Розділ <br /> закупівель",
                'encodeLabel' => false
            ],

            ['attribute' =>'name_tmc',
                'format' => 'raw',
                'label' => "Товар",
                'value' => function($model){

                    return Html::a($model->name_tmc, Url::to(['budget',
                        'sql' => '0',
                        'res' => $model->name_service,
                        'tovar' => $model->name_tmc,
//                        'page' => $model->page_b,
//                        'typerepair' => $model->type_repair
                       ]), ['target'=>'_blank']);
                 },
                'encodeLabel' => false

//     'value'=>function ($data) {
//        return Html::a(Html::encode("View"),'site/index');

            ],



            ['attribute' =>'name_service',
                'label' => "Підрозд.",
                'encodeLabel' => false
            ],
//            ['attribute' =>'page_b',
//                'label' => "Стат'я <br /> бюджету",
//                'encodeLabel' => false
//            ],

//            ['attribute' =>'obj',
//                'label' => "Назва <br /> об'єкта",
//                'encodeLabel' => false
//            ],
//
//            ['attribute' =>'type_repair',
//                'label' => "Вид <br /> ремонту",
//                'encodeLabel' => false
//            ],

            'type_tmc',

            ['attribute' =>'edizm',
                'label' => "Од. <br /> вим.",
                'encodeLabel' => false
            ],
            'price',
            ['attribute' =>'nakop_q',
                'label' => 'підсумок план.<br /> замовл.,кільк.',
                'encodeLabel' => false
            ],
            ['attribute' =>'nakop_v',
                'label' => 'підсумок факт.<br /> видано,кільк.',
                'encodeLabel' => false
            ],
            ['attribute' =>'nakop',
                'label' => 'підсумок <br /> отрим.,кільк.',
                'encodeLabel' => false
            ],
            ['attribute' =>'nakop_y',
                'label' => 'підсумок факт.<br /> не отрим.,кільк.',
                'encodeLabel' => false
            ],
            ['attribute' =>'nakop_z',
                'label' => 'підсумок план.<br /> не отрим.,кільк.',
                'encodeLabel' => false
            ],
            ['attribute' =>'n_cnt',
                'label' => '№ <br /> договора',
                'encodeLabel' => false
            ],
            ['attribute' =>'d_cnt',
                'label' => 'Дата <br /> договора',
                'format' => ['date', 'php:d.m.Y'],
                'encodeLabel' => false
            ],
            ['attribute' =>'cagent',
                'label' => 'Контрагент',
                'encodeLabel' => false
            ],

        ],
    ]);?>


    <table id="header-fixed-ost"></table>

</div>

<?php
