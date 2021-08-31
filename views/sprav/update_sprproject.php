<?php
//namespace app\models;
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\status;
//$role = Yii::$app->user->identity->role;
//Yii::$app->view->registerJsFile('/js/func_js.js', ['yii\web\JqueryAsset']);
//$this->registerJsFile('/js/func_js.js',['depends' => 'yii\web\JqueryAsset']) //, [], ['position' =>  yii\web\View::POS_READY]);
$this->registerJsFile(
    '@web/js/func_js.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

?>
<script>
    window.onload=function(){
        $(document).click(function(e){

            if ($(e.target).closest("#recode-menu").length) return;

            $(".rmenu").hide();

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
        echo $form->field($model, 'id_status')->dropDownList(ArrayHelper::map(status::find()->all(), 'id', 'txt'));
        ?>
        <?= $form->field($model, 'txt')->textarea(['rows' => 3, 'cols' => 25],
            ['onDblClick' => 'rmenu($(this).val(),"#projects-txt")']) ?>
        <div class='rmenu' id='rmenu-projects-txt'></div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'ОК' : 'OK', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>


