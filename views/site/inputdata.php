<?php
// Ввод основных данных для поиска телефонов

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
$this->title = 'Пошук товарів';
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
            ?>

            <?
            //debug($user); ?>

            <? if($user=='all') {
               echo $form->field($model, 'rem')->dropDownList(
                    ArrayHelper::map(app\models\tovar::findbysql(
                            "select ID,rem
                                from vw_rem ")->all(), 'ID', 'rem'),
                   [
                       'onchange' => '$.get("' . Url::to('/budget/web/site/getgrups?res=') .
                           '"+$(this).val(),
                         function(data) {
                         var flag=0,fl=0;
                         $("#inputdata-grup").empty();
                         for(var ii = 0; ii<data.gr.length; ii++) {
                         var q = data.gr[ii].grp;
                         fl = q.indexOf("::");
                         var q1 = q.substr(fl+2);
                         var n = q.substr(0,fl);
                         
                         $("#inputdata-grup").append("<option value="+n+
                         " style="+String.fromCharCode(34)+"font-size: 10px;"+
                         String.fromCharCode(34)+">"+q1+"</option>");
                        } 
                        // $("#inputdataform-work").change();
                  });',
                   ]
            ); }?>
            <? if($user<>'all'){
                echo $form->field($model, 'grup')->dropDownList(
                ArrayHelper::map(app\models\tovar::findbysql(
                    'select 0 as ID,"Всі групи" as grup 
                          union
                         select max(b.ID) as ID,concat(a.grupa,"  (",count(a.grupa),")") as grup
                         from vw_tovar a
                         inner join vw_tgroup b on 
                         trim(a.grupa)=trim(b.grup)
                         where a.rem='."'".$user."'".' and kol_give>0'.
                        ' group by a.grupa')->all(), 'ID', 'grup')
            ); }
                else
                    echo $form->field($model, 'grup')->dropDownList(
                        ArrayHelper::map(app\models\tovar::findbysql(
                            'select 0 as ID,"Всі групи" as grup 
                         union 
                         select max(b.ID) as ID,concat(a.grupa,"  (",count(a.grupa),")") as grup
                         from vw_tovar a
                         inner join vw_tgroup b on 
                         trim(a.grupa)=trim(b.grup)
                         group by a.grupa')->all(), 'ID', 'grup')
                    ); ?>


            <?=$form->field($model, 'tovar')->
                textInput() ?>

            <?= $form->field($model, 'zkol_zak')->
            dropDownList([1 => '=',2 => '>',3 => '>=',4 => '<',5 => '<=',6 => '<>'],['prompt'=>'']) ?>
            <?=$form->field($model, 'kol_zak') ?>
            <div class="clearfix"></div>

<!--            --><?php //if($user<>'all') {
//                $model->zkol_give = 2;
//                $model->kol_give = 0;
//            }
//            ?>
<!---->
<!--                --><?//= $form->field($model, 'zkol_give')->
//                dropDownList([1 => '=',2 => '>',3 => '>=',4 => '<',5 => '<=',6 => '<>'],['prompt'=>'']) ?>
<!--                --><?//=$form->field($model, 'kol_give')->
//                textInput() ?>
<!---->
<!--            <div class="clearfix"></div>-->
<!---->
<!--            --><?//= $form->field($model, 'zkol_zakup')->
//            dropDownList([1 => '=',2 => '>',3 => '>=',4 => '<',5 => '<=',6 => '<>'],['prompt'=>'']) ?>
<!--            --><?//=$form->field($model, 'kol_zakup')->
//            textInput() ?>
<!--            <div class="clearfix"></div>-->

            <?= $form->field($model, 'zost_res')->
            dropDownList([1 => '=',2 => '>',3 => '>=',4 => '<',5 => '<=',6 => '<>'],['prompt'=>'']) ?>
            <?=$form->field($model, 'ost_res')->
            textInput() ?>
            <div class="clearfix"></div>

            <?= $form->field($model, 'zisp_res')->
            dropDownList([1 => '=',2 => '>',3 => '>=',4 => '<',5 => '<=',6 => '<>'],['prompt'=>'']) ?>
            <?=$form->field($model, 'isp_res')->
            textInput() ?>
            <div class="clearfix"></div>

            <?= $form->field($model, 'zostn_res')->
            dropDownList([1 => '=',2 => '>',3 => '>=',4 => '<',5 => '<=',6 => '<>'],['prompt'=>'']) ?>
            <?=$form->field($model, 'ostn_res')->
            textInput() ?>
            <div class="clearfix"></div>

            <?= $form->field($model, 'zostz_res')->
            dropDownList([1 => '=',2 => '>',3 => '>=',4 => '<',5 => '<=',6 => '<>'],['prompt'=>'']) ?>
            <?=$form->field($model, 'ostz_res')->
            textInput() ?>
            <div class="clearfix"></div>


            <div class="form-group">
                <?= Html::submitButton('OK', ['class' => 'btn btn-primary','id' => 'btn_find','onclick'=>'dsave()']); ?>
<!--                --><?//= Html::a('OK', ['/CalcWork/web'], ['class' => 'btn btn-success']) ?>
            </div>

            <?php
            

            ActiveForm::end(); ?>
        </div>
      </div>
</div>
          





