<?php
// Ввод основных данных для поиска данных

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
$this->title = 'Пошук товарів в бюджеті';
ini_set('memory_limit', '1024M');
?>

<script>
     window.addEventListener('load', function(){
       $('#inputdata-id_t').each(function () {
        var txt = $(this).text()
        $(this).html(
            "<span style='color:#111111" + ";'></span>" + txt)
})
    }



    
</script>



<div class="site-login" <?php if(isset(Yii::$app->user->identity->role) && Yii::$app->user->identity->role==3) echo 'id="main_block"'; ?>>
    <h2><?= Html::encode('') ?></h2>
      <div class="row">
         
          <?php //debug(Yii::$app->user->identity); ?> 
          
        <div <?php if(isset(Yii::$app->user->identity->role) && Yii::$app->user->identity->role==3) echo 'class="col-lg-8"'; else echo 'class="col-lg-8"'; ?>>
            <?php $form = ActiveForm::begin(['id' => 'inputdata',
                'options' => [
                    'class' => 'form-horizontal col-lg-25',
                    'enctype' => 'multipart/form-data'
                    
                ]]); ?>
            <?php
            $session = Yii::$app->session;
            $session->open();
            if($session->has('user'))
                $user = $session->get('user');
            else
                $user = '';

            $flg=0;
            $pos=strpos($user,'РЕМ');
            if(!($pos===false))
                $flg=1;
            ?>

            <? //|| $flg==0
//            debug($user);
//            return;

             if($user=='all' || let_all($user) || $user == '') {
               echo $form->field($model, 'name_service')->dropDownList(
                   ArrayHelper::map(app\models\tovar::findbysql(
                       "select ID,rem
                                from vw_rem ")->all(), 'ID', 'rem')
                                );
                 echo $form->field($model, 'else_service')->checkbox([
                     'onchange' => 'show_chservice(this.checked);',
                     'label' => 'Вибрати декілька підрозділів:',
                     'labelOptions' => [
                         'style' => 'padding-left:20px;'
                     ],
                     'disabled' => false
                 ]);

                 ?>
                 <div class="ch_service">
                     <?
                     $j=0;
                     foreach ($service as $v)
                     {
                         //$i='s'.$v['ID'];
                         $j++;
                         if($j==1) continue;
                         $i='s'.$j;
                         //debug($i);
                         echo $form->field($model, "$i")->checkbox([
//                             'onchange' => 'show_chservice(this.checked);',
                             'label' => $v['rem'],
                             'labelOptions' => [
                                 'style' => 'padding-left:20px;'
                             ],
                             'disabled' => false
                         ]);

                     }
                     ?>
                 </div>
                 <?
             }

            echo $form->field($model, 'type_act')->dropDownList(
            ArrayHelper::map(app\models\spr_typeact::findbysql(
            "select -1 as id,'Всі записи' as type_act 
                          union
            select id,type_act
            from spr_typeact ")->all(), 'id', 'type_act')
            );

            echo $form->field($model, 'type_repair')->dropDownList(
                ArrayHelper::map(app\models\spr_typerepair::findbysql(
                    "select -1 as id,'Всі записи' as vid_repair 
                          union
            select id,vid_repair
            from spr_typerepair ")->all(), 'id', 'vid_repair')
            );

            echo $form->field($model, 'else_repair')->checkbox([
                'onchange' => 'show_chrep(this.checked);',
                'label' => 'Вибрати декілька видів ремонту:',
                'labelOptions' => [
                    'style' => 'padding-left:20px;'
                ],
                'disabled' => false
            ]);
          ?>
            <div class="ch_repair">
          <?
            foreach ($repair as $v)
            {
               $i='r'.$v['id'];
                echo $form->field($model, "$i")->checkbox([
//                    'onchange' => 'show_chrep1(this.checked);',
                    'label' => $v['vid_repair'],
                    'labelOptions' => [
                        'style' => 'padding-left:20px;'
                    ],
                    'disabled' => false
                ]);

            }
          ?>
                </div>
          <?


            echo $form->field($model, 'type_tmc')->dropDownList(
                ArrayHelper::map(app\models\spr_typetmc::findbysql(
                    "select -1 as id,'Всі' as typetmc 
                          union
            select id,typetmc
            from spr_typetmc ")->all(), 'id', 'typetmc')
            );



                //            echo $form->field($model, 'spec')->dropDownList(
//                ArrayHelper::map(app\models\spr_spec::findbysql(
//                    "select id,name_spec
//            from spr_spec ")->all(), 'id', 'name_spec')
//            );

            if($user<>'all'){
//                echo $form->field($model, 'spec')->dropDownList(
//                    ArrayHelper::map(app\models\tovar::findbysql(
//                        'select 0 as ID,"Всі групи" as grup
//                          union
//                         select max(b.ID) as ID,a.grupa as grup
//                         from vw_tovar a
//                         inner join vw_tgroup b on
//                         trim(a.grupa)=trim(b.grup)
//                         where a.rem='."'".$user."'".' and kol_give>0'.
//                        ' group by a.grupa')->all(), 'ID', 'grup')
//                );
                echo $form->field($model, 'spec')->dropDownList(
                    ArrayHelper::map(app\models\tovar::findbysql(
                        'select * from spr_grup')->all(), 'ID', 'grup')
                );

            }
                // where a.rem='."'".$user."'".' and kol_give>0
            else
//                echo $form->field($model, 'spec')->dropDownList(
//                    ArrayHelper::map(app\models\tovar::findbysql(
//                        'select 0 as ID,"Всі групи" as grup
//                         union
//                         select max(b.ID) as ID,a.grupa as grup
//                         from vw_tovar a
//                         inner join vw_tgroup b on
//                         trim(a.grupa)=trim(b.grup)
//                         group by a.grupa')->all(), 'ID', 'grup')
//                );
            echo $form->field($model, 'spec')->dropDownList(
                ArrayHelper::map(app\models\tovar::findbysql(
                    'select * from spr_grup')->all(), 'ID', 'grup')
            );

          echo $form->field($model, 'else_spec')->checkbox([
              'onchange' => 'show_chspec(this.checked);',
              'label' => 'Вибрати декілька розділів закупівель:',
              'labelOptions' => [
                  'style' => 'padding-left:20px;'
              ],
              'disabled' => false
          ]);

          ?>
            <div class="ch_spec">
                <?
                foreach ($spec as $v)
                {
                    $i='sp'.$v['id'];
                    echo $form->field($model, "$i")->checkbox([
//                    'onchange' => 'show_chrep1(this.checked);',
                        'label' => $v['name_spec'],
                        'labelOptions' => [
                            'style' => 'padding-left:20px;'
                        ],
                        'disabled' => false
                    ]);

                }
                ?>
            </div>
            <?


            echo $form->field($model, 'obj')->dropDownList(
                            ArrayHelper::map(app\models\spr_obj::findbysql(
                                "select id,name_obj
                        from spr_obj ")->all(), 'id', 'name_obj')
                        );

            ?>

            <?=$form->field($model, 'name_tmc')->
                textInput();  ?>

            <?=$form->field($model, 'dname')->
            textInput();  ?>

<!--            <br>-->
<!--            --><?//= $form->field($model, 'date1')->
//            widget(\yii\jui\DatePicker::classname(), [
//                'language' => 'uk'
//            ]) ?>
<!--            --><?//= $form->field($model, 'date2')->
//            widget(\yii\jui\DatePicker::classname(), [
//                'language' => 'uk'
//            ]) ?>

            <div class="clearfix"></div>

            <?= $form->field($model, 'm1')->
            dropDownList([1 => 'Січень',2 => 'Лютий',3 => 'Березень',4 => 'Квітень',5 => 'Травень',
                6 => 'Червень',7 => 'Липень',8 => 'Серпень',9 => 'Вересень',
                10 => 'Жовтень',11 => 'Листопад',12 => 'Грудень'],['prompt'=>'']) ?>
            <?= $form->field($model, 'm2')->
            dropDownList([1 => 'Січень',2 => 'Лютий',3 => 'Березень',4 => 'Квітень',5 => 'Травень',
                6 => 'Червень',7 => 'Липень',8 => 'Серпень',9 => 'Вересень',
                10 => 'Жовтень',11 => 'Листопад',12 => 'Грудень'],['prompt'=>'']) ?>

            <div class="clearfix"></div>

            <?= $form->field($model, 'znakop_q')->
            dropDownList([1 => '=',2 => '>',3 => '>=',4 => '<',5 => '<=',6 => '<>',7 => 'пусто',8 => 'не пусто'],['prompt'=>'']) ?>
            <?=$form->field($model, 'nakop_q')->
            textInput() ?>
            <div class="clearfix"></div>

            <?= $form->field($model, 'znakop_v')->
            dropDownList([1 => '=',2 => '>',3 => '>=',4 => '<',5 => '<=',6 => '<>',7 => 'пусто',8 => 'не пусто'],['prompt'=>'']) ?>
            <?=$form->field($model, 'nakop_v')->
            textInput() ?>
            <div class="clearfix"></div>


            <?= $form->field($model, 'znakop')->
            dropDownList([1 => '=',2 => '>',3 => '>=',4 => '<',5 => '<=',6 => '<>',7 => 'пусто',8 => 'не пусто'],['prompt'=>'']) ?>
            <?=$form->field($model, 'nakop')->
            textInput() ?>
            <div class="clearfix"></div>

            <?= $form->field($model, 'znakop_o')->
            dropDownList([1 => '=',2 => '>',3 => '>=',4 => '<',5 => '<=',6 => '<>',7 => 'пусто',8 => 'не пусто'],['prompt'=>'']) ?>
            <?=$form->field($model, 'nakop_o')->
            textInput() ?>
            <div class="clearfix"></div>

            <?= $form->field($model, 'znakop_z')->
            dropDownList([1 => '=',2 => '>',3 => '>=',4 => '<',5 => '<=',6 => '<>',7 => 'пусто',8 => 'не пусто'],['prompt'=>'']) ?>
            <?=$form->field($model, 'nakop_z')->
            textInput() ?>
            <div class="clearfix"></div>

            <?= $form->field($model, 'znakop_n')->
            dropDownList([1 => '=',2 => '>',3 => '>=',4 => '<',5 => '<=',6 => '<>',7 => 'пусто',8 => 'не пусто'],['prompt'=>'']) ?>
            <?=$form->field($model, 'nakop_n')->
            textInput() ?>
            <div class="clearfix"></div>

            <?= $form->field($model, 'add_rec')->checkbox() ?>


            <div class="form-group">
                <?= Html::submitButton('OK', ['class' => 'btn btn-primary','id' => 'btn_find','onclick'=>'dsave()']); ?>
<!--                --><?//= Html::a('OK', ['/CalcWork/web'], ['class' => 'btn btn-success']) ?>
            </div>

            <?php
            

            ActiveForm::end(); ?>
        </div>
      </div>
</div>
<script>

function show_chrep(p){
    if (p == 1) {
    $('.ch_repair').show();
    $('.field-inputdatabudget-type_repair').hide();
    $('label[for=inputdatabudget-else_repair]').css('font-weight', 'bold');
    }
    else {
    $('.ch_repair').hide();
    $('.field-inputdatabudget-type_repair').show();
    $('label[for=inputdatabudget-else_repair]').css('font-weight', 'normal');
}
}

function show_chservice(p){
    if (p == 1) {
        $('.ch_service').show();
        $('.field-inputdatabudget-name_service').hide();
        $('label[for=inputdatabudget-else_service]').css('font-weight', 'bold');
    }
    else {
       $('.ch_service').hide();
        $('.field-inputdatabudget-name_service').show();
        $('label[for=inputdatabudget-else_service]').css('font-weight', 'normal');
    }
}

function show_chspec(p){
    if (p == 1) {
        $('.ch_spec').show();
        $('.field-inputdatabudget-spec').hide();
        $('label[for=inputdatabudget-else_spec]').css('font-weight', 'bold');
    }
    else {
        $('.ch_spec').hide();
        $('.field-inputdatabudget-spec').show();
        $('label[for=inputdatabudget-else_spec]').css('font-weight', 'normal');
    }
}
</script>




