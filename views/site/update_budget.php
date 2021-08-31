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
$m = intval(date('n'));

$f1='rq_'.$m;
$f2='rp_'.$m;
$f3='oq_'.$m;
$f4='up_'.$m;

if ($m>1) {
    $lf1 = 'rq_' . ($m-1);
    $lf2 = 'rp_' . ($m-1);
    $lf3 = 'oq_' . ($m-1);
    $lf4 = 'up_' . ($m-1);
}
if ($m>3) {
    $lf1 = 'rq_' . ($m-1);
    $lf2 = 'rp_' . ($m-1);
    $lf3 = 'oq_' . ($m-1);
    $lf4 = 'up_' . ($m-1);

    $llf1 = 'rq_' . ($m-2);
    $llf2 = 'rp_' . ($m-2);
    $llf3 = 'oq_' . ($m-2);
    $llf4 = 'up_' . ($m-2);

    $lllf1 = 'rq_' . ($m-3);
    $lllf2 = 'rp_' . ($m-3);
    $lllf3 = 'oq_' . ($m-3);
    $lllf4 = 'up_' . ($m-3);
}

if ($m>4) {
    $llllf1 = 'rq_' . ($m-4);
    $llllf2 = 'rp_' . ($m-4);
    $llllf3 = 'oq_' . ($m-4);
    $llllf4 = 'up_' . ($m-4);
}


if ($m<>12) {
    $nf1 = 'rq_' . ($m+1);
    $nf2 = 'rp_' . ($m+1);
    $nf3 = 'oq_' . ($m+1);
    $nf4 = 'up_' . ($m+1);
}
?>
<script>
   window.onload=function(){
    $(document).click(function(e){

	  if ($(e.target).closest("#recode-menu").length) return;

	   $("#rmenu").hide();

	  e.stopPropagation();

	  });
   }        
</script>

<br>
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
    <?= $form->field($model, 'name_service')->textInput() ?>

        <span class="edizm">
            <?= "Одиниця вимірювання: ".$model->edizm; ?>
        </span>

        <?= $form->field($model, 'name_tmc')->textInput() ?>

        <?php
        $yet=0;
        if ($m>1 && $m<5) {
            echo $form->field($model, $lf1)->textInput();
            echo $form->field($model, $lf2)->textInput();
            echo $form->field($model, $lf3)->textInput();
            echo $form->field($model, $lf4)->textInput();
        }
        if ($m>4) {
            echo $form->field($model, $llllf1)->textInput();
            echo $form->field($model, $llllf2)->textInput();
            echo $form->field($model, $llllf3)->textInput();
            echo $form->field($model, $llllf4)->textInput();

            echo $form->field($model, $lllf1)->textInput();
            echo $form->field($model, $lllf2)->textInput();
            echo $form->field($model, $lllf3)->textInput();
            echo $form->field($model, $lllf4)->textInput();

            echo $form->field($model, $llf1)->textInput();
            echo $form->field($model, $llf2)->textInput();
            echo $form->field($model, $llf3)->textInput();
            echo $form->field($model, $llf4)->textInput();

            echo $form->field($model, $lf1)->textInput();
            echo $form->field($model, $lf2)->textInput();
            echo $form->field($model, $lf3)->textInput();
            echo $form->field($model, $lf4)->textInput();
            $yet=1;
        }

        if ($m>3 && $yet==0) {
            echo $form->field($model, $lllf1)->textInput();
            echo $form->field($model, $lllf2)->textInput();
            echo $form->field($model, $lllf3)->textInput();
            echo $form->field($model, $lllf4)->textInput();

            echo $form->field($model, $llf1)->textInput();
            echo $form->field($model, $llf2)->textInput();
            echo $form->field($model, $llf3)->textInput();
            echo $form->field($model, $llf4)->textInput();

            echo $form->field($model, $lf1)->textInput();
            echo $form->field($model, $lf2)->textInput();
            echo $form->field($model, $lf3)->textInput();
            echo $form->field($model, $lf4)->textInput();
        }


        ?>

        <?= $form->field($model, $f1)->textInput() ?>
        <?= $form->field($model, $f2)->textInput() ?>
        <?= $form->field($model, $f3)->textInput() ?>
        <?= $form->field($model, $f4)->textInput() ?>

        <?php
        if ($m<>12) {
            echo $form->field($model, $nf1)->textInput();
            echo $form->field($model, $nf2)->textInput();
            echo $form->field($model, $nf3)->textInput();
            echo $form->field($model, $nf4)->textInput();
        }
        ?>

        <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'ОК' : 'OK', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>


