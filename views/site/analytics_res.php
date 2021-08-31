<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\grid\SerialColumn;

$this->title = 'Результат аналітики';

?>
<div class="site-spr1">
	
    <h3 class="res-analit"><?= Html::encode($this->title) ?></h3>
<span class="res-analit1">Всього: </span>336<br><br><br><br><?= GridView::widget([
            'dataProvider' => $dataProvider,'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed'],
            'summary' => false,
            'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name_tmc','edizm','nakop_q','nakop_p','nakop','nakop_s','nakop_o','nakop_n','nakop_z','nakop_x',] ]); ?> </div><?php echo Html::a('Експорт в Excel', ['site/analytics_excel'
            ],
                ['class' => 'btn btn-info excel_btn',
                'data' => [
                'method' => 'post',
                'params' => [
               
                'data' => "select name_tmc,edizm,SUM(nakop_q) as nakop_q,SUM(nakop_p) as nakop_p,SUM(nakop) as nakop,SUM(nakop_s) as nakop_s,SUM(nakop_o) as nakop_o,SUM(nakop_n) as nakop_n,SUM(nakop_z) as nakop_z,SUM(nakop_x) as nakop_x from (SELECT *,(rq_1+rq_2+rq_3+rq_4+rq_5+rq_6) as nakop,(rp_1+rp_2+rp_3+rp_4+rp_5+rp_6) as nakop_s,(oq_1+oq_2+oq_3+oq_4+oq_5+oq_6) as nakop_o,(q_1+q_2+q_3+q_4+q_5+q_6) as nakop_q,(p_1+p_2+p_3+p_4+p_5+p_6) as nakop_p,(rn_1+rn_2+rn_3+rn_4+rn_5+rn_6) as nakop_n,(rz_1+rz_2+rz_3+rz_4+rz_5+rz_6) as nakop_z,(rx_1+rx_2+rx_3+rx_4+rx_5+rx_6) as nakop_x,(v1+v2+v3+v4+v5+v6) as nakop_v,(rq_1+rq_2+rq_3) as arq_1,(rq_4+rq_5+rq_6) as arq_2,(rq_7+rq_8+rq_9) as arq_3,(rq_10+rq_11+rq_12) as arq_4,(rq_1+rq_2+rq_3+rq_4+rq_5+rq_6+rq_7+rq_8+rq_9+rq_10+rq_11+rq_12) as arq_y,(rp_1+rp_2+rp_3) as arp_1,(rp_4+rp_5+rp_6) as arp_2,(rp_7+rp_8+rp_9) as arp_3,(rp_10+rp_11+rp_12) as arp_4,(rp_1+rp_2+rp_3+rp_4+rp_5+rp_6+rp_7+rp_8+rp_9+rp_10+rp_11+rp_12) as arp_y,(oq_1+oq_2+oq_3) as aoq_1,(oq_4+oq_5+oq_6) as aoq_2,(oq_7+oq_8+oq_9) as aoq_3,(oq_10+oq_11+oq_12) as aoq_4,(oq_1+oq_2+oq_3+oq_4+oq_5+oq_6+oq_7+oq_8+oq_9+oq_10+oq_11+oq_12) as aoq_y,(q_1+q_2+q_3) as aqs_1,(q_4+q_5+q_6) as aqs_2,(q_7+q_8+q_9) as aqs_3,(q_10+q_11+q_12) as aqs_4,(q_1+q_2+q_3+q_4+q_5+q_6+q_7+q_8+q_9+q_10+q_11+q_12) as aqs_y,(p_1+p_2+p_3) as aps_1,(p_4+p_5+p_6) as aps_2,(p_7+p_8+p_9) as aps_3,(p_10+p_11+p_12) as aps_4,(p_1+p_2+p_3+p_4+p_5+p_6+p_7+p_8+p_9+p_10+p_11+p_12) as aps_y,(rn_1+rn_2+rn_3) as arn_1,(rn_4+rn_5+rn_6) as arn_2,(rn_7+rn_8+rn_9) as arn_3,(rn_10+rn_11+rn_12) as arn_4,(rn_1+rn_2+rn_3+rn_4+rn_5+rn_6+rn_7+rn_8+rn_9+rn_10+rn_11+rn_12) as arn_y,(rz_1+rz_2+rz_3) as arz_1,(rz_4+rz_5+rz_6) as arz_2,(rz_7+rz_8+rz_9) as arz_3,(rz_10+rz_11+rz_12) as arz_4,(rz_1+rz_2+rz_3+rz_4+rz_5+rz_6+rz_7+rz_8+rz_9+rz_10+rz_11+rz_12) as arz_y,(rx_1+rx_2+rx_3) as arx_1,(rx_4+rx_5+rx_6) as arx_2,(rx_7+rx_8+rx_9) as arx_3,(rx_10+rx_11+rx_12) as arx_4,(rx_1+rx_2+rx_3+rx_4+rx_5+rx_6+rx_7+rx_8+rx_9+rx_10+rx_11+rx_12) as arx_y FROM vw_budget  where 1=1  and (vid_repair=1 or vid_repair=3 or vid_repair=5 or vid_repair=6) and service in                     (select a.id from spr_service a,vw_rem b where a.service=b.rem and b.ID in(18840,18862,18882,18899,18923,18925,18932,18945,18970,18972,18784,19100,16979)) ORDER BY name_service) as q GROUP BY name_tmc,edizm"
               
            ],
                 ]]); ?>