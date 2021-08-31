<?php
//namespace app\models;
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\spr_res;
use app\models\status_sch;
$role = Yii::$app->user->identity->role;
?>
<div class="row">
    <div class="col-lg-6">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'enableAjaxValidation' => false,]); ?>


            <?php
            if(Yii::$app->session->hasFlash('error')): ?>
                <span class="label label-danger">
                <?php
                echo Yii::$app->session->getFlash('error');
                endif;
                 ?>
             </span>
    <?= $form->field($model, 'name_tmc')->textInput() ?>
    <?= $form->field($model, 'price')->textInput() ?>


        <?
        echo $form->field($model, 'type_act')->dropDownList(
            ArrayHelper::map(app\models\spr_typeact::findbysql(
                'select * from spr_typeact')->all(), 'id', 'type_act')
        );

        echo $form->field($model, 'typetmc')->dropDownList(
            ArrayHelper::map(app\models\spr_typetmc::findbysql(
                'select * from spr_typetmc')->all(), 'id', 'typetmc')
        );

        echo $form->field($model, 'page')->dropDownList(
            ArrayHelper::map(app\models\spr_page::findbysql(
                'select * from spr_page')->all(), 'id', 'page')
        );

        echo $form->field($model, 'vid_repair')->dropDownList(
            ArrayHelper::map(app\models\spr_typerepair::findbysql(
                'select * from spr_typerepair')->all(), 'id', 'vid_repair')
        );

        echo $form->field($model, 'spec')->dropDownList(
        ArrayHelper::map(app\models\spr_spec::findbysql(
        'select id,name_spec from spr_spec')->all(), 'id', 'name_spec')
        );

        echo $form->field($model, 'name_obj')->dropDownList(
            ArrayHelper::map(app\models\spr_obj::findbysql(
                'select * from spr_obj')->all(), 'id', 'name_obj'));

         echo $form->field($model, 'dname_obj')->textInput();

        echo $form->field($model, 'ed_izm')->dropDownList(
            ArrayHelper::map(app\models\spr_edizm::findbysql(
         'select * from spr_edizm')->all(), 'id', 'ed_izm')
        );
        ?>

        <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'ОК' : 'OK', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>


