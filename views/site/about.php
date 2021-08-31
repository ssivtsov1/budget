<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$zag = $model->title;

$this->title = 'Особова інформація';
//$this->params['breadcrumbs'][] = $this->title;
?>
<!--<div class="site-about">-->
<div class=<?= $model->style_title ?> >
    <h4><?= Html::encode($zag) ?></h4>
</div>

<div class=<?= $model->style1 ?> >
    <h4><?= Html::encode($model->info1) ?></h4>

</div>

<div class=<?= $model->style2 ?> >

<!--    <h3>--><?//= Html::encode($model->info2) ?><!--</h3>-->

<br>
    <br>
    <br>

</div>


<code><?//= __FILE__ ?></code>

<!--</div>-->
