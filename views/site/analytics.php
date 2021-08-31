<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\status_sch;
$this->title = 'Аналітика';
$model->src = $src;

?>
<script>

    window.addEventListener('load', function(){
        localStorage.setItem("gr_name_service", 'false');
        localStorage.setItem("gr_type_act", 'false');
        localStorage.setItem("gr_type_tmc", 'false');
        localStorage.setItem("gr_type_repair", 'false');
        localStorage.setItem("gr_page_b", 'false');
        localStorage.setItem("gr_spec", 'false');
        localStorage.setItem("gr_obj", 'false');
        localStorage.setItem("gr_name_tmc", 'false');
        localStorage.setItem("gr_edizm", 'false');
    });


    // Фомируем список полей для группировки (в порядке выбора)
    function def_gr(v,name){
        var s=name.substr(11),p1='',p2='',p3='',p4='',p5='',p6='',p7='',p8='',p9='',r;
        localStorage.setItem(s,v);
        r=localStorage.getItem("gr_name_service");
        //alert(11);
        if(localStorage.getItem("gr_name_service")=='true'){
            p1=$('#analytics-ord').val();
            if (p1.indexOf("gr_name_service") == -1)
                $('#analytics-ord').val(p1+" gr_name_service");
        }

        if(localStorage.getItem("gr_type_act")=='true'){
            p2=$('#analytics-ord').val();
            if (p2.indexOf("gr_type_act") == -1)
                $('#analytics-ord').val(p2+" gr_type_act");
        }

        if(localStorage.getItem("gr_type_tmc")=='true'){
            p3=$('#analytics-ord').val();
            if (p3.indexOf("gr_type_tmc") == -1)
                $('#analytics-ord').val(p3+" gr_type_tmc");
        }
        if(localStorage.getItem("gr_type_repair")=='true'){
            p4=$('#analytics-ord').val();
            if (p4.indexOf("gr_type_repair") == -1)
                $('#analytics-ord').val(p4+" gr_type_repair");
        }

        if(localStorage.getItem("gr_page_b")=='true'){
            p5=$('#analytics-ord').val();
            if (p5.indexOf("gr_page_b") == -1) {
                $('#analytics-ord').val(p5+" gr_page_b");
            }
        }
        if(localStorage.getItem("gr_spec")=='true'){
            p6=$('#analytics-ord').val();
            if (p6.indexOf("gr_spec") == -1)
                $('#analytics-ord').val(p6+" gr_spec");
        }
        if(localStorage.getItem("gr_obj")=='true'){
            p6=$('#analytics-ord').val();
            if (p6.indexOf("gr_obj") == -1)
                $('#analytics-ord').val(p6+" gr_obj");
            //alert($('#analytics-ord').val());
        }
        if(localStorage.getItem("gr_name_tmc")=='true'){
            p6=$('#analytics-ord').val();
            if (p6.indexOf("gr_name_tmc") == -1)
                $('#analytics-ord').val(p6+" gr_name_tmc");
        }
        if(localStorage.getItem("gr_edizm")=='true'){
            p6=$('#analytics-ord').val();
            if (p6.indexOf("gr_edizm") == -1)
                $('#analytics-ord').val(p6+" gr_edizm");
        }

    }

    // Убираем список полей агрегирования, если выбрана операция количества значений
    function def_cnt(v){
        if(v==5)
            $('.pole-gra').hide();
        else
            $('.pole-gra').show();
    }

    // Выбор всех итоговых полей
    function sel_all(v){

        if(v) {

            $('#analytics-gra_nakop_x').prop('checked', true);
            $('#analytics-gra_nakop').prop('checked', true);
            $('#analytics-gra_nakop_z').prop('checked', true);
            $('#analytics-gra_nakop_n').prop('checked', true);
            $('#analytics-gra_nakop_o').prop('checked', true);
            $('#analytics-gra_nakop_s').prop('checked', true);
            $('#analytics-gra_nakop_p').prop('checked', true);
            $('#analytics-gra_nakop_q').prop('checked', true);

        }
        else {
            $('#analytics-gra_nakop_x').prop('checked', false);
            $('#analytics-gra_nakop').prop('checked', false);
            $('#analytics-gra_nakop_z').prop('checked', false);
            $('#analytics-gra_nakop_n').prop('checked', false);
            $('#analytics-gra_nakop_o').prop('checked', false);
            $('#analytics-gra_nakop_s').prop('checked', false);
            $('#analytics-gra_nakop_p').prop('checked', false);
            $('#analytics-gra_nakop_q').prop('checked', false);
        }
    }

    function proc_ok(){
        if($('#analytics-gra_oper').val()==5) return;
        if(localStorage.getItem("gr_name_service")=='true' ||
            localStorage.getItem("gr_type_act")=='true' ||
            localStorage.getItem("gr_type_tmc")=='true' ||
            localStorage.getItem("gr_type_repair")=='true' ||
            localStorage.getItem("gr_page_b")=='true' ||
            localStorage.getItem("gr_spec")=='true' ||
            localStorage.getItem("gr_obj")=='true' ||
            localStorage.getItem("gr_name_tmc")=='true' ||
            localStorage.getItem("gr_edizm")=='true')
    {

        if(!($('#analytics-gra_nakop_q').prop("checked") ||
            $('#analytics-gra_nakop').prop("checked") ||
            $('#analytics-gra_nakop_z').prop("checked") ||
            $('#analytics-gra_nakop_x').prop("checked") ||
            $('#analytics-gra_nakop_n').prop("checked") ||
            $('#analytics-gra_nakop_o').prop("checked") ||
            $('#analytics-gra_nakop_s').prop("checked") ||
            $('#analytics-gra_nakop_p').prop("checked")))
        {
            alert('Введіть поле групування!');
            $('#analytics-ord').val("error");
        }
    }


    }


</script>
<div class="site-login">

    <h3><?= Html::encode($this->title) ?></h3>

    <div class="row row_reg">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'analytics',
                'options' => [
                    'class' => 'form-horizontal col-lg-6',
                    'enctype' => 'multipart/form-data',
                    'fieldConfig' => ['errorOptions' => ['encode' => false, 'class' => 'help-block']

                    ]]]); ?>
<!--            <div class="analit-filtr">-->
<!--                <h5 class="text-primary"><b>--><?//= Html::encode("Фільтрація") ?><!--</b></h5>-->
<!---->
<!--               --><?php //if($user=='all') {
//               echo $form->field($model, 'name_service')->dropDownList(
//                   ArrayHelper::map(app\models\tovar::findbysql(
//                       "select ID,rem
//                                from vw_rem ")->all(), 'ID', 'rem')
//                              ); }
//
//            echo $form->field($model, 'type_act')->dropDownList(
//            ArrayHelper::map(app\models\spr_typeact::findbysql(
//            "select -1 as id,'Всі записи' as type_act
//                          union
//            select id,type_act
//            from spr_typeact ")->all(), 'id', 'type_act')
//            );
//
//            echo $form->field($model, 'type_repair')->dropDownList(
//                ArrayHelper::map(app\models\spr_typerepair::findbysql(
//                    "select -1 as id,'Всі записи' as vid_repair
//                          union
//            select id,vid_repair
//            from spr_typerepair ")->all(), 'id', 'vid_repair')
//            );
//
//
//            echo $form->field($model, 'type_tmc')->dropDownList(
//                ArrayHelper::map(app\models\spr_typetmc::findbysql(
//                    "select -1 as id,'Всі' as typetmc
//                          union
//            select id,typetmc
//            from spr_typetmc ")->all(), 'id', 'typetmc')
//            );
//
////            echo $form->field($model, 'spec')->dropDownList(
////                ArrayHelper::map(app\models\spr_spec::findbysql(
////                    "select id,name_spec
////            from spr_spec ")->all(), 'id', 'name_spec')
////            );
//
//            if($user<>'all'){
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
//                ); }
//            else
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
//
//            echo $form->field($model, 'obj')->dropDownList(
//                            ArrayHelper::map(app\models\spr_obj::findbysql(
//                                "select id,name_obj
//                        from spr_obj ")->all(), 'id', 'name_obj')
//                        );
//
//
//           ?>
<!--            </div>-->
<!--            -->


            <h5 class="text-primary"><b><?= Html::encode("Групові операції") ?></b></h5>

            <br>

            <div class="pole-gr">
                <h5><u><?= Html::encode("В розрізі:") ?></u></h5>
                <br>
                <?= $form->field($model, 'gr_name_service')->checkbox(['onChange' => 'def_gr($(this).prop("checked"),"#analytics-gr_name_service")']); ?>
                <?= $form->field($model, 'gr_type_act')->checkbox(['onChange' => 'def_gr($(this).prop("checked"),"#analytics-gr_type_act")']); ?>
                <?= $form->field($model, 'gr_type_tmc')->checkbox(['onChange' => 'def_gr($(this).prop("checked"),"#analytics-gr_type_tmc")']); ?>
                <?= $form->field($model, 'gr_type_repair')->checkbox(['onChange' => 'def_gr($(this).prop("checked"),"#analytics-gr_type_repair")']); ?>
                <?= $form->field($model, 'gr_page_b')->checkbox(['onChange' => 'def_gr($(this).prop("checked"),"#analytics-gr_page_b")']); ?>
                <?= $form->field($model, 'gr_spec')->checkbox(['onChange' => 'def_gr($(this).prop("checked"),"#analytics-gr_spec")']); ?>
                <?= $form->field($model, 'gr_obj')->checkbox(['onChange' => 'def_gr($(this).prop("checked"),"#analytics-gr_obj")']); ?>
                <?= $form->field($model, 'gr_name_tmc')->checkbox(['onChange' => 'def_gr($(this).prop("checked"),"#analytics-gr_name_tmc")']); ?>
                <?= $form->field($model, 'gr_edizm')->checkbox(['onChange' => 'def_gr($(this).prop("checked"),"#analytics-gr_edizm")']); ?>
                <?= $form->field($model, 'ord')->textInput(); ?>
                <?= $form->field($model, 'src')->textInput(); ?>
            </div>
            <div class="pole-gra">
                <h5><u><?= Html::encode("Поле групування:") ?></u></h5>
                <br>
                <?= $form->field($model, 'gra_nakop_q')->checkbox(); ?>
                <?= $form->field($model, 'gra_nakop_p')->checkbox(); ?>
                <?= $form->field($model, 'gra_nakop')->checkbox(); ?>
                <?= $form->field($model, 'gra_nakop_s')->checkbox(); ?>
                <?= $form->field($model, 'gra_nakop_o')->checkbox(); ?>
                <?= $form->field($model, 'gra_nakop_n')->checkbox(); ?>
                <?= $form->field($model, 'gra_nakop_z')->checkbox(); ?>
                <?= $form->field($model, 'gra_nakop_x')->checkbox(); ?>
                <?= $form->field($model, 'sel_all')->checkbox(['onChange' => 'sel_all($(this).prop("checked"))']); ?>
            </div>
            <div class="pole-grf">
                <?= $form->field($model, 'gra_oper')->
                dropDownList([1 => 'Сума',2 => 'Максимум',3 => 'Мінімум',4 => 'Середнє',5 => 'Кількість'],
                    ['onChange' => 'def_cnt($(this).val())']) ?>
            </div>

            <div class="pole-grh">
                <h5 class="text-primary"><b><?= Html::encode("Фільтрація по груповим операціям:") ?></b></h5>
                <br>
                <?= $form->field($model, 'grh_having')->
                dropDownList([1 => '=',2 => '>',3 => '>=',4 => '<',5 => '<=',6 => '<>'],['prompt'=>'Виберіть операцію']) ?>
                <?= $form->field($model, 'grh_value')->textInput(); ?>

            </div>
<!--            <div class="pole-sort">-->
<!--                <h5 class="text-primary"><b>--><?//= Html::encode("Сортування результату:") ?><!--</b></h5>-->
<!--                <br>-->
<!--                --><?//= $form->field($model, 'grs_sort')->
//                dropDownList([1 => 'Підрозділ',2 => 'Статус заявки',3 => 'Дата заявки',4 => 'Дата оплати',
//                    5 => 'Послуга',6 => 'Робота',7 => 'Сума з ПДВ',8 => 'Сума без ПДВ',
//                    9 => 'Вартість робіт',10 => 'Транспорт всього',11 => 'Доставка бригади'],['prompt'=>'Виберіть поле']) ?>
<!--                --><?//= $form->field($model, 'grs_dir')->
//                dropDownList([1 => 'За збільшенням',2 => 'За зменшенням'],['prompt'=>'Виберіть вид сортування']) ?>
<!---->
<!--            </div>-->
            <br>
            <div class="form-group">
                <?= Html::submitButton('OK', ['onClick' => 'proc_ok()'],
                    ['class' => 'btn btn-primary']);

                ?>

            </div>



            <?php

            ActiveForm::end(); ?>
        </div>
    </div>
</div>

<!--<script>-->
<!--    // Фомируем список полей для группировки (в порядке выбора)-->
<!--    function def_gr(v,name){-->
<!--        var s=name.substr(11),p1='',p2='',p3='',p4='',p5='',p6='',p7='',p8='',p9='',r;-->
<!--        localStorage.setItem(s,v);-->
<!--        r=localStorage.getItem("gr_name_service");-->
<!---->
<!--        if(localStorage.getItem("gr_name_service")=='true'){-->
<!--            p1=$('#analytics-ord').val();-->
<!--            if (p1.indexOf("gr_name_service") == -1)-->
<!--                $('#analytics-ord').val(p1+" gr_name_service");-->
<!--        }-->
<!---->
<!--        if(localStorage.getItem("gr_type_act")=='true'){-->
<!--            p2=$('#analytics-ord').val();-->
<!--            if (p2.indexOf("gr_type_act") == -1)-->
<!--                $('#analytics-ord').val(p2+" gr_type_act");-->
<!--        }-->
<!---->
<!--        if(localStorage.getItem("gr_type_tmc")=='true'){-->
<!--            p3=$('#analytics-ord').val();-->
<!--            if (p3.indexOf("gr_type_tmc") == -1)-->
<!--                $('#analytics-ord').val(p3+" gr_type_tmc");-->
<!--        }-->
<!--        if(localStorage.getItem("gr_type_repair")=='true'){-->
<!--            p4=$('#analytics-ord').val();-->
<!--            if (p4.indexOf("gr_type_repair") == -1)-->
<!--                $('#analytics-ord').val(p4+" gr_type_repair");-->
<!--        }-->
<!---->
<!--        if(localStorage.getItem("gr_page_b")=='true'){-->
<!--            p5=$('#analytics-ord').val();-->
<!--            if (p5.indexOf("gr_page_b") == -1) {-->
<!--                $('#analytics-ord').val(p5+" gr_page_b");-->
<!--            }-->
<!--        }-->
<!--        if(localStorage.getItem("gr_spec")=='true'){-->
<!--            p6=$('#analytics-ord').val();-->
<!--            if (p6.indexOf("gr_spec") == -1)-->
<!--                $('#analytics-ord').val(p6+" gr_spec");-->
<!--        }-->
<!--        if(localStorage.getItem("gr_obj")=='true'){-->
<!--            p6=$('#analytics-ord').val();-->
<!--            if (p6.indexOf("gr_obj") == -1)-->
<!--                $('#analytics-ord').val(p6+" gr_obj");-->
<!--                //alert($('#analytics-ord').val());-->
<!--        }-->
<!--        if(localStorage.getItem("gr_name_tmc")=='true'){-->
<!--            p6=$('#analytics-ord').val();-->
<!--            if (p6.indexOf("gr_name_tmc") == -1)-->
<!--                $('#analytics-ord').val(p6+" gr_name_tmc");-->
<!--        }-->
<!--        if(localStorage.getItem("gr_ed_izm")=='true'){-->
<!--            p6=$('#analytics-ord').val();-->
<!--            if (p6.indexOf("gr_ed_izm") == -1)-->
<!--                $('#analytics-ord').val(p6+" gr_ed_izm");-->
<!--        }-->
<!---->
<!--    }-->
<!---->
<!--    // Убираем список полей агрегирования, если выбрана операция количества значений-->
<!--    function def_cnt(v){-->
<!--        if(v==5)-->
<!--            $('.pole-gra').hide();-->
<!--        else-->
<!--            $('.pole-gra').show();-->
<!--    }-->
<!---->
<!--    function proc_ok(){-->
<!--        if($('#analytics-gra_oper').val()==5) return;-->
<!--        if(localStorage.getItem("gr_name_service")=='true' ||-->
<!--            localStorage.getItem("gr_type_act")=='true' ||-->
<!--            localStorage.getItem("gr_type_tmc")=='true' ||-->
<!--            localStorage.getItem("gr_type_repair")=='true' ||-->
<!--            localStorage.getItem("gr_page_b")=='true' ||-->
<!--            localStorage.getItem("gr_spec")=='true') ||-->
<!--            localStorage.getItem("gr_obj")=='true') ||-->
<!--            localStorage.getItem("gr_name_tmc")=='true') ||-->
<!--            localStorage.getItem("gr_ed_izm")=='true')-->
<!--        {-->
<!---->
<!--            if(!($('#analytics-gra_nakop_q').prop("checked") ||-->
<!--                $('#analytics-gra_nakop').prop("checked") ||-->
<!--                $('#analytics-gra_nakop_z').prop("checked") ||-->
<!--                $('#analytics-gra_nakop_x').prop("checked") ||-->
<!--                $('#analytics-gra_nakop_n').prop("checked") ||-->
<!--                $('#analytics-gra_nakop_o').prop("checked") ||-->
<!--                $('#analytics-gra_nakop_s').prop("checked") ||-->
<!--                $('#analytics-gra_nakop_p').prop("checked"))) {-->
<!--                alert('Введіть поле групування!');-->
<!--                $('#analytics-ord').val("error");-->
<!--              }-->
<!--        }-->
<!---->
<!---->
<!--    }-->
<!---->
<!---->
<!--</script>-->







