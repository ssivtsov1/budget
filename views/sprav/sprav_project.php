<?php


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\grid\SerialColumn;
use app\models\Status_project;

$this->title = 'Довідник моїх проектів';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-spr1">
<?= Html::a('Добавити', ['createproject'], ['class' => 'btn btn-success']) ?>

    <h3><?= Html::encode($this->title) ?></h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'summary' => false,
        'emptyText' => 'Нічого не знайдено',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'status',
                'value' => 'status.txt',
            ],
            'txt',
             [
                /**
                 * Указываем класс колонки
                 */
                'class' => \yii\grid\ActionColumn::class,
                 'buttons'=>[
                     'delete'=>function ($url, $model) {
                         $customurl=Yii::$app->getUrlManager()->createUrl(['/sprav/delete','id'=>$model['id'],'mod'=>'sprproject']); //$model->id для AR
                         return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-remove-circle"></span>', $customurl,
                             ['title' => Yii::t('yii', 'Видалити'),'data' => [
                                 'confirm' => 'Ви впевнені, що хочете видалити цей запис ?',
                             ], 'data-pjax' => '0']);
                     },

                     'update'=>function ($url, $model) {
                         $customurl=Yii::$app->getUrlManager()->createUrl(['/sprav/update','id'=>$model['id'],'mod'=>'sprproject']); //$model->id для AR
                         return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $customurl,
                             ['title' => Yii::t('yii', 'Редагувати'), 'data-pjax' => '0']);
                     }
                 ],
                /**
                 * Определяем набор кнопочек. По умолчанию {view} {update} {delete}
                 */
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>


    
</div>



