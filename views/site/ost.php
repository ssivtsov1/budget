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

$this->title = 'Залишки товарів';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-spr">

    <h4><?php

        echo Html::encode($this->title.'. Всього знайдено: '.$kol);
    ?></h4>
    <?= Html::a(' Пошук', ['ost'], ['class' => 'btn btn-success glyphicon glyphicon-search']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'summary' => false,
        'emptyText' => 'Нічого не знайдено',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                /**
                 * Указываем класс колонки
                 */
                'class' => \yii\grid\ActionColumn::class,
                'buttons'=>[

                    'update'=>function ($url, $model) use ($sql) {
                        $customurl=Yii::$app->getUrlManager()->
                        createUrl(['/site/update','id'=>$model['ID'],'mod'=>'ost','sql'=>$sql]);
                        return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $customurl,
                            ['title' => Yii::t('yii', 'Редагувати'), 'data-pjax' => '0']);
                    }
                ],
                /**
                 * Определяем набор кнопочек. По умолчанию {view} {update} {delete}
                 */
                'template' => '{update}',
            ],

            [
                'format' => 'raw',
                'header' => 'Детально',
                'value' => function($model) {
                       return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-book"></span>', ['site/detal'],[
                            'data' => [
                                'method' => 'post',
                                'params' => [
                                    'id' => $model->ID,
                                    'tovar' => $model->tovar,
                                    'rem' => $model->rem
                                ]]],
                            ['title' => Yii::t('yii', 'Сформувати рахунок'), 'data-pjax' => '0']
                        );

                }
            ],

             'rem',

            'grupa',
            'edizm',
            'tovar',
            ['attribute' =>'kol_zak',
                'label' => 'Кількість <br /> замовлено',
                'encodeLabel' => false
            ],
            //'kol_zak',
            ['attribute' =>'kol_give',
                'label' => 'Кількість <br /> видано',
                'encodeLabel' => false
            ],
            //'kol_give',
            ['attribute' =>'kol_zakup',
                'label' => 'Кількість <br /> залишилось купити',
                'encodeLabel' => false
            ],
           // 'kol_zakup',
            ['attribute' =>'ost_res',
                'label' => 'Отримано РЕМ <br /> (кількість)',
                'encodeLabel' => false
            ],
            //'ost_res',
            ['attribute' =>'ostp_res',
                'label' => 'Отримано РЕМ <br /> (вартість тис.грн.)',
                'encodeLabel' => false
            ],
            //'ostp_res',
            ['attribute' =>'isp_res',
                'label' => 'Списано РЕМ <br /> (кількість)',
                'encodeLabel' => false
            ],
            //'isp_res',
            ['attribute' =>'ostn_res',
                'label' => 'Не викор. РЕМ <br /> (кількість)',
                'encodeLabel' => false
            ],
            ['attribute' =>'ostz_res',
                'label' => 'Не отрим. РЕМ <br /> (кількість)',
                'encodeLabel' => false
            ],
        ],
    ]);?>


</div>

<?php
