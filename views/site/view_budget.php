<script>

   window.addEventListener('load', function () {


       //$("table").scrollTableBody();
       //$('table').stickyTableHeaders();

       var tableOffset = $(".table").offset().top;
       var $header = $(".table > thead").clone();
       var $body = $(".table > tbody").clone();
       var $fixedHeader = $("#header-fixed").append($header);
       //var $fixedtab = $("#header-fixed").append($body);
       $("#header-fixed").width($(".table").width());




       $(window).bind("scroll", function() {
           var offset = $(this).scrollTop();

           if (offset >= tableOffset && $fixedHeader.is(":hidden")) {

               $fixedHeader.show();
           }
           else if (offset < tableOffset) {
               $fixedHeader.hide();
           }

           $("#header-fixed th").each(function(index){
               var index2 = index;
               $(this).width(function(index2){
                   return $(".table th").eq(index).width();
               });
           });
       });


       // alert(111);
       $(window).scroll(function () {

           // if (window.scrollY > 270) //270 is the amount of scroll after which the cols should stick
           // {
           //     top = $(window).scrollTop() - 20; //15 is the margin from left of fixed columns
           //     no_columns_to_stick1 = 5;
           //     //alert(top);
           //
           //     $('table th').each(function () {
           //
           //         $(this).addClass('stick-relative-top');
           //
           //         $(this).css('top', 200);
           //
           //     });
           // }
           // else {
           //     $('table th').each(function () {
           //
           //         $(this).removeClass('stick-relative-top');
           //     });
           // }

           if(kol<1300) {

               // горизонтальный scroll
               if (window.scrollX > 1)
                   $fixedHeader.hide();
               if (window.scrollX > 270) //270 is the amount of scroll after which the cols should stick

               {

                   left = $(window).scrollLeft() - 15; //15 is the margin from left of fixed columns


                   if(kol>800) {
                       no_columns_to_stick = 4  //stick first 8 columns

                   }
                   else{
                       no_columns_to_stick = 8
                   }


                   //


                   $('table td:nth-child(-n+' + no_columns_to_stick + ')').each(function () {

                       $(this).addClass('stick-relative');

                       $(this).css('left', left);

                   });
                   $('table th:nth-child(-n+' + no_columns_to_stick + ')').each(function () {

                       $(this).addClass('stick-relative');

                       $(this).css('left', left);

                   });

               }

               else {

                   $('table td:nth-child(-n+' + no_columns_to_stick + ')').each(function () {

                       $(this).removeClass('stick-relative');

                   });
                   $('table th:nth-child(-n+' + no_columns_to_stick + ')').each(function () {

                       $(this).removeClass('stick-relative');

                   });

               }
           }
       });

   });



</script>

<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
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

    <?= Html::a(' Пошук', ['budget'], ['class' => 'btn btn-success glyphicon glyphicon-search']);
    echo '<span> &nbsp </span>';
    echo Html::a(' Добавити запис', ['site/addrec'],[
        'data' => [
        'method' => 'get',
        'params' => [
            'sql' => $sql,

        ],],
        'class' => 'btn btn-success glyphicon glyphicon-plus']);
    echo '<span> &nbsp </span>';
    echo Html::a('Аналітика ', ['site/analytics'],[
        'data' => [
            'method' => 'get',
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
            [
                /**
                 * Указываем класс колонки
                 */
                'class' => \yii\grid\ActionColumn::class,
                'buttons'=>[
                    'delete'=>function ($url, $model) use ($sql){
                        $customurl=Yii::$app->getUrlManager()->createUrl(['/site/delete_budget','id'=>$model['id'],'mod'=>'budget','sql'=>$sql]); //$model->id для AR
                        if ($model->id_zakaz==1)
                        return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-remove-circle"></span>', $customurl,
                            ['title' => Yii::t('yii', 'Видалити'),'data' => [
                                'confirm' => 'Ви впевнені, що хочете видалити цей запис ?',
                            ], 'data-pjax' => '0']);
                    },
                    'update'=>function ($url, $model) use ($sql) {
                        $customurl=Yii::$app->getUrlManager()->
                        createUrl(['/site/update_budget','id'=>$model['id'],'mod'=>'budget','sql'=>$sql]);
                        return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $customurl,
                            ['title' => Yii::t('yii', 'Редагувати'), 'data-pjax' => '0']);
                    }
                ],
                /**
                 * Определяем набор кнопочек. По умолчанию {view} {update} {delete}
                 */
                'template' => '{update} {delete}',
            ],

            ['attribute' =>'spec',
                'label' => "Розділ <br /> закупівель",
                'encodeLabel' => false
            ],
            'name_tmc',
            //'page_b',

            //'name_service',
            ['attribute' =>'name_service',
                'label' => "Підрозд.",
                'encodeLabel' => false
            ],
            ['attribute' =>'page_b',
                'label' => "Стат'я <br /> бюджету",
                'encodeLabel' => false
            ],
           // 'obj',
            ['attribute' =>'obj',
                'label' => "Назва <br /> об'єкта",
                'encodeLabel' => false
            ],
            //'dname_obj',

            //'type_repair',
            ['attribute' =>'type_repair',
                'label' => "Вид <br /> ремонту",
                'encodeLabel' => false
            ],
            //'spec',


            'type_tmc',
            ['attribute' =>'dname_obj',
                'label' => "Дисп. назва <br /> об'єкта",
                'encodeLabel' => false
            ],
//            'name_act',
//            'lot',
//            'edizm',
            ['attribute' =>'edizm',
                'label' => "Од. <br /> вим.",
                'encodeLabel' => false
            ],
            'price',
            ['attribute' =>'nakop_q',
                'label' => 'підсумок <br /> замовл.,кільк.',
                'encodeLabel' => false
            ],
            //'nakop_q',
            ['attribute' =>'nakop_p',
                'label' => 'підсумок <br /> замовл.,варт.',
                'encodeLabel' => false
            ],
            //'nakop_p',
            ['attribute' =>'nakop',
                'label' => 'підсумок <br /> отрим.,кільк.',
                'encodeLabel' => false
            ],
            ['attribute' =>'nakop_s',
                'label' => 'підсумок <br /> отрим.,варт.',
                'encodeLabel' => false
            ],
            //'nakop_s',
            ['attribute' =>'nakop_o',
                'label' => 'підсумок <br /> спис.,кільк.',
                'encodeLabel' => false
            ],
            //'nakop_o',
            ['attribute' =>'nakop_n',
                'label' => 'підсумок <br /> не викор.,кільк.',
                'encodeLabel' => false
            ],
            ['attribute' =>'nakop_z',
                'label' => 'підсумок <br /> не отримано.,кільк.',
                'encodeLabel' => false
            ],
            ['attribute' =>'nakop_x',
                'label' => 'підсумок <br /> не отрим.,варт.',
                'encodeLabel' => false
            ],
//            'q_1',
            ['attribute' =>'q_1',
                'label' => 'Січень <br /> кільк.',
                'encodeLabel' => false
            ],
//            'p_1',
            ['attribute' =>'p_1',
                'label' => 'Січень <br /> варт.',
                'encodeLabel' => false
            ],

//            'rq_1',
//            ['attribute' =>'v1',
//                'label' => 'Січень,кільк. <br /> (видано. РЕМ)',
//                'encodeLabel' => false
//            ],

            ['attribute' =>'rq_1',
                'label' => 'Січень,кільк. <br /> (отрим. РЕМ)',
                'encodeLabel' => false
            ],
//            'rp_1',
            ['attribute' =>'rp_1',
                'label' => 'Січень,варт. <br /> (отрим. РЕМ тис.грн. )',
                'encodeLabel' => false
            ],
           // Січень,кільк.(використ. РЕМ)
           // 'oq_1',
            ['attribute' =>'oq_1',
                'label' => 'Січень,кільк. <br /> (використ. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'up_1',
                'label' => 'Січень,варт. <br /> (використ. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],

//            'rn_1',
            ['attribute' =>'rn_1',
                'label' => 'Січень,кільк. <br /> (не викорис. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'rz_1',
                'label' => 'Січень,кільк. <br /> (не отрим. РЕМ)',
                'encodeLabel' => false
            ],

            ['attribute' =>'rx_1',
                'label' => 'Січень,варт. <br /> (не отрим. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],

//            'q_2',
            ['attribute' =>'q_2',
                'label' => 'Лютий <br /> кільк.',
                'encodeLabel' => false
            ],
//            'p_2',
            ['attribute' =>'p_2',
                'label' => 'Лютий <br /> варт.',
                'encodeLabel' => false
            ],

//            ['attribute' =>'v2',
//                'label' => 'Лютий,кільк. <br /> (видано. РЕМ)',
//                'encodeLabel' => false
//            ],

//            'rq_2',
//            'rp_2',
            ['attribute' =>'rq_2',
                'label' => 'Лютий,кільк. <br /> (отрим. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'rp_2',
                'label' => 'Лютий,варт. <br /> (отрим. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],
            ['attribute' =>'oq_2',
                'label' => 'Лютий,кільк. <br /> (використ. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'up_2',
                'label' => 'Лютий,варт. <br /> (використ. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],

//            'rn_2',
//            'rz_2',
//            'rx_2',
            ['attribute' =>'rn_2',
                'label' => 'Лютий,кільк. <br /> (не викорис. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'rz_2',
                'label' => 'Лютий,кільк. <br /> (не отрим. РЕМ)',
                'encodeLabel' => false
            ],

            ['attribute' =>'rx_2',
                'label' => 'Лютий,варт. <br /> (не отрим. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],

//            'q_3',
//            'p_3',
            ['attribute' =>'q_3',
                'label' => 'Березень <br /> кільк.',
                'encodeLabel' => false
            ],
            ['attribute' =>'p_3',
                'label' => 'Березень <br /> варт.',
                'encodeLabel' => false
            ],

//            ['attribute' =>'v3',
//                'label' => 'Березень,кільк. <br /> (видано. РЕМ)',
//                'encodeLabel' => false
//            ],
//            'rq_3',
//            'rp_3',
            ['attribute' =>'rq_3',
                'label' => 'Березень,кільк. <br /> (отрим. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'rp_3',
                'label' => 'Березень,варт. <br /> (отрим. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],
            ['attribute' =>'oq_3',
                'label' => 'Березень,кільк. <br /> (використ. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'up_3',
                'label' => 'Березень,варт. <br /> (використ. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],

//            'rn_3',
//            'rz_3',
//            'rx_3',
            ['attribute' =>'rn_3',
                'label' => 'Березень,кільк. <br /> (не викорис. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'rz_3',
                'label' => 'Березень,кільк. <br /> (не отрим. РЕМ)',
                'encodeLabel' => false
            ],

            ['attribute' =>'rx_3',
                'label' => 'Березень,варт. <br /> (не отрим. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],

//            'aq_1',
//            'ap_1',

//            'q_4',
//            'p_4',
            ['attribute' =>'q_4',
                'label' => 'Квітень <br /> кільк.',
                'encodeLabel' => false
            ],
            ['attribute' =>'p_4',
                'label' => 'Квітень <br /> варт.',
                'encodeLabel' => false
            ],

//            ['attribute' =>'v4',
//                'label' => 'Квітень,кільк. <br /> (видано. РЕМ)',
//                'encodeLabel' => false
//            ],
//            'rq_4',
//            'rp_4',
            ['attribute' =>'rq_4',
                'label' => 'Квітень,кільк. <br /> (отрим. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'rp_4',
                'label' => 'Квітень,варт. <br /> (отрим. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],
            ['attribute' =>'oq_4',
                'label' => 'Квітень,кільк. <br /> (використ. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'up_4',
                'label' => 'Квітень,варт. <br /> (використ. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],

//            'rn_4',
//            'rz_4',
//            'rx_4',
            ['attribute' =>'rn_4',
                'label' => 'Квітень,кільк. <br /> (не викорис. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'rz_4',
                'label' => 'Квітень,кільк. <br /> (не отрим. РЕМ)',
                'encodeLabel' => false
            ],

            ['attribute' =>'rx_4',
                'label' => 'Квітень,варт. <br /> (не отрим. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],


//            'q_5',
//            'p_5',
            ['attribute' =>'q_5',
                'label' => 'Травень <br /> кільк.',
                'encodeLabel' => false
            ],
            ['attribute' =>'p_5',
                'label' => 'Травень <br /> варт.',
                'encodeLabel' => false
            ],

//            ['attribute' =>'v5',
//                'label' => 'Травень,кільк. <br /> (видано. РЕМ)',
//                'encodeLabel' => false
//            ],
//            'rq_5',
//            'rp_5',
            ['attribute' =>'rq_5',
                'label' => 'Травень,кільк. <br /> (отрим. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'rp_5',
                'label' => 'Травень,варт. <br /> (отрим. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],
            ['attribute' =>'oq_5',
                'label' => 'Травень,кільк. <br /> (використ. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'up_5',
                'label' => 'Травень,варт. <br /> (використ. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],

//            'rn_5',
//            'rz_5',
//            'rx_5',
            ['attribute' =>'rn_5',
                'label' => 'Травень,кільк. <br /> (не викорис. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'rz_5',
                'label' => 'Травень,кільк. <br /> (не отрим. РЕМ)',
                'encodeLabel' => false
            ],

            ['attribute' =>'rx_5',
                'label' => 'Травень,варт. <br /> (не отрим. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],

//            'q_6',
//            'p_6',
            ['attribute' =>'q_6',
                'label' => 'Червень <br /> кільк.',
                'encodeLabel' => false
            ],
            ['attribute' =>'p_6',
                'label' => 'Червень <br /> варт.',
                'encodeLabel' => false
            ],

//            ['attribute' =>'v6',
//                'label' => 'Червень,кільк. <br /> (видано. РЕМ)',
//                'encodeLabel' => false
//            ],
//            'rq_6',
//            'rp_6',
            ['attribute' =>'rq_6',
                'label' => 'Червень,кільк. <br /> (отрим. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],
            ['attribute' =>'rp_6',
                'label' => 'Червень,варт. <br /> (отрим. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'oq_6',
                'label' => 'Червень,кільк. <br /> (використ. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'up_6',
                'label' => 'Червень,варт. <br /> (використ. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],

//            'rn_6',
//            'rz_6',
//            'rx_6',
            ['attribute' =>'rn_6',
                'label' => 'Червень,кільк. <br /> (не викорис. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'rz_6',
                'label' => 'Червень,кільк. <br /> (не отрим. РЕМ)',
                'encodeLabel' => false
            ],

            ['attribute' =>'rx_6',
                'label' => 'Червень,варт. <br /> (не отрим. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],

//            'aq_2',
//            'ap_2',

//            'q_7',
//            'p_7',
            ['attribute' =>'q_7',
                'label' => 'Липень <br /> кільк.',
                'encodeLabel' => false
            ],
            ['attribute' =>'p_7',
                'label' => 'Липень <br /> варт.',
                'encodeLabel' => false
            ],

//            ['attribute' =>'v7',
//                'label' => 'Липень,кільк. <br /> (видано. РЕМ)',
//                'encodeLabel' => false
//            ],
//            'rq_7',
//            'rp_7',
            ['attribute' =>'rq_7',
                'label' => 'Липень,кільк. <br /> (отрим. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'rp_7',
                'label' => 'Липень,варт. <br /> (отрим. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],
            ['attribute' =>'oq_7',
                'label' => 'Липень,кільк. <br /> (використ. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'up_7',
                'label' => 'Липень,варт. <br /> (використ. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],


//            'rn_7',
//            'rz_7',
//            'rx_7',
            ['attribute' =>'rn_7',
                'label' => 'Липень,кільк. <br /> (не викорис. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'rz_7',
                'label' => 'Липень,кільк. <br /> (не отрим. РЕМ)',
                'encodeLabel' => false
            ],

            ['attribute' =>'rx_7',
                'label' => 'Липень,варт. <br /> (не отрим. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],


//            'q_8',
//            'p_8',
            ['attribute' =>'q_8',
                'label' => 'Серпень <br /> кільк.',
                'encodeLabel' => false
            ],
            ['attribute' =>'p_8',
                'label' => 'Серпень <br /> варт.',
                'encodeLabel' => false
            ],
//            'rq_8',
//            'rp_8',

//            ['attribute' =>'v8',
//                'label' => 'Серпень,кільк. <br /> (видано. РЕМ)',
//                'encodeLabel' => false
//            ],

            ['attribute' =>'rq_8',
                'label' => 'Серпень,кільк. <br /> (отрим. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'rp_8',
                'label' => 'Серпень,варт. <br /> (отрим. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],
            ['attribute' =>'oq_8',
                'label' => 'Серпень,кільк. <br /> (використ. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'up_8',
                'label' => 'Серпень,варт. <br /> (використ. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],

//            'rn_8',
//            'rz_8',
//            'rx_8',
            ['attribute' =>'rn_8',
                'label' => 'Серпень,кільк. <br /> (не викорис. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'rz_8',
                'label' => 'Серпень,кільк. <br /> (не отрим. РЕМ)',
                'encodeLabel' => false
            ],

            ['attribute' =>'rx_8',
                'label' => 'Серпень,варт. <br /> (не отрим. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],


//            'q_9',
//            'p_9',
            ['attribute' =>'q_9',
                'label' => 'Вересень <br /> кільк.',
                'encodeLabel' => false
            ],
            ['attribute' =>'p_9',
                'label' => 'Вересень <br /> варт.',
                'encodeLabel' => false
            ],

//            ['attribute' =>'v9',
//                'label' => 'Вересень,кільк. <br /> (видано. РЕМ)',
//                'encodeLabel' => false
//            ],
//            'rq_9',
//            'rp_9',
            ['attribute' =>'rq_9',
                'label' => 'Вересень,кільк. <br /> (отрим. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'rp_9',
                'label' => 'Вересень,варт. <br /> (отрим. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],
            ['attribute' =>'oq_9',
                'label' => 'Вересень,кільк. <br /> (використ. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'up_9',
                'label' => 'Вересень,варт. <br /> (використ. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],

//            'rn_9',
//            'rz_9',
//            'rx_9',
            ['attribute' =>'rn_9',
                'label' => 'Вересень,кільк. <br /> (не викорис. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'rz_9',
                'label' => 'Вересень,кільк. <br /> (не отрим. РЕМ)',
                'encodeLabel' => false
            ],

            ['attribute' =>'rx_9',
                'label' => 'Вересень,варт. <br /> (не отрим. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],

//            'aq_3',
//            'ap_3',

//            'q_10',
//            'p_10',
            ['attribute' =>'q_10',
                'label' => 'Жовтень <br /> кільк.',
                'encodeLabel' => false
            ],
            ['attribute' =>'p_10',
                'label' => 'Жовтень <br /> варт.',
                'encodeLabel' => false
            ],

//            ['attribute' =>'v10',
//                'label' => 'Жовтень,кільк. <br /> (видано. РЕМ)',
//                'encodeLabel' => false
//            ],
//            'rq_10',
//            'rp_10',
            ['attribute' =>'rq_10',
                'label' => 'Жовтень,кільк. <br /> (отрим. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'rp_10',
                'label' => 'Жовтень,варт. <br /> (отрим. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],
            ['attribute' =>'oq_10',
                'label' => 'Жовтень,кільк. <br /> (використ. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'up_10',
                'label' => 'Жовтень,варт. <br /> (використ. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],

//            'rn_10',
//            'rz_10',
//            'rx_10',
            ['attribute' =>'rn_10',
                'label' => 'Жовтень,кільк. <br /> (не викорис. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'rz_10',
                'label' => 'Жовтень,кільк. <br /> (не отрим. РЕМ)',
                'encodeLabel' => false
            ],

            ['attribute' =>'rx_10',
                'label' => 'Жовтень,варт. <br /> (не отрим. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],

//            'q_11',
//            'p_11',
            ['attribute' =>'q_11',
                'label' => 'Листопад <br /> кільк.',
                'encodeLabel' => false
            ],
            ['attribute' =>'p_11',
                'label' => 'Листопад <br /> варт.',
                'encodeLabel' => false
            ],

//            ['attribute' =>'v11',
//                'label' => 'Листопад,кільк. <br /> (видано. РЕМ)',
//                'encodeLabel' => false
//            ],
//            'rq_11',
//            'rp_11',
            ['attribute' =>'rq_11',
                'label' => 'Листопад,кільк. <br /> (отрим. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'rp_11',
                'label' => 'Листопад,варт. <br /> (отрим. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],
            ['attribute' =>'oq_11',
                'label' => 'Листопад,кільк. <br /> (використ. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'up_11',
                'label' => 'Листопад,варт. <br /> (використ. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],

//            'rn_11',
//            'rz_11',
//            'rx_11',
            ['attribute' =>'rn_11',
                'label' => 'Листопад,кільк. <br /> (не викорис. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'rz_11',
                'label' => 'Листопад,кільк. <br /> (не отрим. РЕМ)',
                'encodeLabel' => false
            ],

            ['attribute' =>'rx_11',
                'label' => 'Листопад,варт. <br /> (не отрим. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],

//            'q_12',
//            'p_12',
            ['attribute' =>'q_12',
                'label' => 'Грудень <br /> кільк.',
                'encodeLabel' => false
            ],
            ['attribute' =>'p_12',
                'label' => 'Грудень <br /> варт.',
                'encodeLabel' => false
            ],

//            ['attribute' =>'v12',
//                'label' => 'Грудень,кільк. <br /> (видано. РЕМ)',
//                'encodeLabel' => false
//            ],
//            'rq_12',
//            'rp_12',
            ['attribute' =>'rq_12',
                'label' => 'Грудень,кільк. <br /> (отрим. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'rp_12',
                'label' => 'Грудень,варт. <br /> (отрим. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],
            ['attribute' =>'oq_12',
                'label' => 'Грудень,кільк. <br /> (використ. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'up_12',
                'label' => 'Грудень,варт. <br /> (використ. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],

//            'rn_12',
//            'rz_12',
//            'rx_12',
            ['attribute' =>'rn_12',
                'label' => 'Грудень,кільк. <br /> (не викорис. РЕМ)',
                'encodeLabel' => false
            ],
            ['attribute' =>'rz_12',
                'label' => 'Грудень,кільк. <br /> (не отрим. РЕМ)',
                'encodeLabel' => false
            ],

            ['attribute' =>'rx_12',
                'label' => 'Грудень,варт. <br /> (не отрим. РЕМ тис.грн.)',
                'encodeLabel' => false
            ],

//            'aq_4',
//            'ap_4',

            'year_q',
            'year_p',

        ],
    ]);?>


    <table id="header-fixed"></table>


    <!---->
<!--            </div>-->

<!---->
<!--    <div class="outer">-->
<!--            <div class="withScroll">-->
<!--                <table>-->
<!--                    <tr>-->
<!--                        <th class=table_fix>Вид ТМЦ</th>-->
<!--                        <th class=table_fix2>Стат'я бюджету</th>-->
<!--                        <th>Col 2</th>-->
<!--                        <th>Col 3</th>-->
<!--                        <th>Col 4</th>-->
<!--                        <th >Col 5</th>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        --><?php
//                        $data=$dataProvider->getModels();
//                        $k=count($data);
//                        for($i=0;$i<$k;$i++){
//                        ?>
<!--                            <th class=table_fix>--><?php //echo $data[$i]['type_tmc'] ?><!--</th>-->
<!--                            <td class=table_fix2>--><?php //echo $data[$i]['page_b'] ?><!--</td>-->
<!--                            <td>col 2 - A (WITH LONGER CONTENT)</td>-->
<!--                            <td>col 3 - A</td>-->
<!--                            <td>col 4 - A</td>-->
<!--                            <td >col 5 - A</td>-->
<!--                         </tr>-->
<!--                        --><?php //} ?>
<!---->
<!--                </table>-->
<!--            </div>-->
<!--    </div>-->
<!---->
<!---->
</div>

<?php
