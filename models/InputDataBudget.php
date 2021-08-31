<?php
/* Ввод основных данных для поиска товаров в бюджете */

namespace app\models;

use Yii;
use yii\base\Model;

class InputDataBudget extends Model
{

    public $id;
    public $type_act;         // тип деятельности
    public $type_tmc;         // Тип ТМЦ
    public $page_b;           // Статья бюджета
    public $name_service;     // Служба
    public $type_repair;      // Вид ремонта
    public $spec;             // Раздел спецификации
    public $obj;              // Название объекта
    public $name_tmc;         // Название товара
    public $price;            // Цена
    public $lot;              // Лот
    public $date1;            // Период дата1
    public $date2;            // Период дата2
    public $m1;               // Период месяц1
    public $m2;               // Период месяц2
    public $znakop_q;
    public $nakop_q;
    public $znakop_v;
    public $nakop_v;
    public $znakop;
    public $nakop;
    public $znakop_o;
    public $nakop_o;
    public $znakop_z;
    public $nakop_z;
    public $znakop_n;
    public $nakop_n;
    public $dname;
    public $else_repair;
    public $else_service;
    public $else_spec;
    public $add_rec;    // Добавленные пользователем записи
// Виды ремонта
    public $r1;
    public $r2;
    public $r3;
    public $r4;
    public $r5;
    public $r6;

// Подразделения
    public $s1;
    public $s2;
    public $s3;
    public $s4;
    public $s5;
    public $s6;
    public $s7;
    public $s8;
    public $s9;
    public $s10;
    public $s11;
    public $s12;
    public $s13;
    public $s14;
    public $s15;
    public $s16;
    public $s17;
    public $s18;
    public $s19;
    public $s20;
    public $s21;
    public $s22;
    public $s23;
    public $s24;
    public $s25;
    public $s26;
    public $s27;
    public $s28;
    public $s29;
    public $s30;
    public $s31;
    public $s32;
    public $s33;
    public $s34;
    public $s35;
    public $s36;
    public $s37;
    public $s38;
    public $s39;
    public $s40;
    public $s41;
    public $s42;
    public $s43;
    public $s44;
    public $s45;
    public $s46;
    public $s47;
    public $s48;
    public $s49;
    public $s50;
    public $s51;
    public $s52;
    public $s53;
    public $s54;

    public $sp1;
    public $sp2;
    public $sp3;
    public $sp4;
    public $sp5;
    public $sp6;
    public $sp7;
    public $sp8;
    public $sp9;
    public $sp10;
    public $sp11;
    public $sp12;
    public $sp13;
    public $sp14;
    public $sp15;
    public $sp16;
    public $sp17;
    public $sp18;
    public $sp19;
    public $sp20;
    public $sp21;
    public $sp22;
    public $sp23;
    public $sp24;
    public $sp25;
    public $sp26;
    public $sp27;
    public $sp28;
    public $sp29;
    public $sp30;
    public $sp31;
    public $sp32;
    public $sp33;
    public $sp34;
    public $sp35;
    public $sp36;
    public $sp37;
    public $sp38;
    public $sp39;
    public $sp40;
    public $sp41;
    public $sp42;

    public function attributeLabels()
    {
        return [
            'name_service' => 'Підрозділ:',
            'name_tmc' => 'Назва ТМЦ',
            'spec' => 'Розділ закупівель',
            'page_b' => 'Стаття бюджету',
            'type_repair' => 'Вид ремонту',
            'type_act' => 'Тип діяльності',
            'type_tmc' => 'Вид ТМЦ',
            'obj' => 'Назва обʼєкту',
            'lot' => 'Лот',
            'dname_obj' => 'Дисп. назва обʼекта',
            'dname' => 'Дисп. назва обʼекта',
            'price' => 'Ціна',
            'date1' => 'Період з',
            'date2' => 'по',
            'm1' => 'Період з',
            'm2' => 'по',
            'znakop_q' => 'Замовл,кільк.',
            'nakop_q' => '',
            'znakop_v' => 'Видано,кільк.',
            'nakop_v' => '',
            'znakop' => 'Отримано,кільк.',
            'nakop' => '',
            'znakop_o' => 'Використано,кільк.',
            'nakop_o' => '',
            'znakop_z' => 'Неотрим,кільк.',
            'nakop_z' => '',
            'znakop_n' => 'Невикор,кільк.',
            'nakop_n' => '',
            'add_rec' => 'Добавлені оператором записи',

        ];
    }

    public function rules()
    {
        return [
            [['id','add_rec','name_service', 'name_tmc','dname','else_repair','else_service','else_spec',
                'spec', 'page_b', 'type_repair', 'type_act', 'type_tmc', 'obj','m1','m2',
                'lot', 'dname_obj', 'price', 'date1', 'date2','znakop_v', 'nakop_v',
                'znakop_q', 'nakop_q','znakop','nakop','r1','r2','r3','r4','r5','r6',
                's1',
                's2',
                's3',
                's4',
                's5',
                's6',
                's7',
                's8',
                's9',
                's10',
                's11',
                's12',
                's13',
                's14',
                's15',
                's16',
                's17',
                's18',
                's19',
                's20',
                's21',
                's22',
                's23',
                's24',
                's25',
                's26',
                's27',
                's28',
                's29',
                's30',
                's31',
                's32',
                's33',
                's34',
                's35',
                's36',
                's37',
                's38',
                's39',
                's40',
                's41',
                's42',
                's43',
                's44',
                's45',
                's46',
                's47',
                's48',
                's49',
                's50',
                's51',
                's52',
                's53',
                's54',

                'sp1',
                'sp2',
                'sp3',
                'sp4',
                'sp5',
                'sp6',
                'sp7',
                'sp8',
                'sp9',
                'sp10',
                'sp11',
                'sp12',
                'sp13',
                'sp14',
                'sp15',
                'sp16',
                'sp17',
                'sp18',
                'sp19',
                'sp20',
                'sp21',
                'sp22',
                'sp23',
                'sp24',
                'sp25',
                'sp26',
                'sp27',
                'sp28',
                'sp29',
                'sp30',
                'sp31',
                'sp32',
                'sp33',
                'sp34',
                'sp35',
                'sp36',
                'sp37',
                'sp38',
                'sp39',
                'sp40',
                'sp41',
                'sp42',

                'znakop_o', 'nakop_o','znakop_z', 'nakop_z','znakop_n', 'nakop_n'], 'safe']
        ];
    }

    // Метод для создания строки запроса с накопительными итогами
    public function gen_nakop($m1, $m2, $out = '')
    {
        $s = '';
        $s1 = '';
        $s2 = '';
        $s3 = '';
        $s4 = '';
        $s5 = '';
        $s6 = '';
        $s7 = '';
        $s8 = '';
        for ($i = $m1; $i <= $m2; $i++) {
            $s .= 'rq_' . $i . '+';
            $s1 .= 'rp_' . $i . '+';
            $s2 .= 'oq_' . $i . '+';
            $s3 .= 'q_' . $i . '+';
            $s4 .= 'p_' . $i . '+';
            $s5 .= 'rn_' . $i . '+';
            $s6 .= 'rz_' . $i . '+';
            $s7 .= 'rx_' . $i . '+';

            $s8 .= 'v' . $i . '+';
        }

        if($out=='') {
            // Создание поквартальных итогов
            $arq_1 = '(rq_1+rq_2+rq_3) as arq_1';
            $arq_2 = '(rq_4+rq_5+rq_6) as arq_2';
            $arq_3 = '(rq_7+rq_8+rq_9) as arq_3';
            $arq_4 = '(rq_10+rq_11+rq_12) as arq_4';
            $arq_y = '(rq_1+rq_2+rq_3+rq_4+rq_5+rq_6+rq_7+rq_8+rq_9+rq_10+rq_11+rq_12) as arq_y';
            $arq = $arq_1.','.$arq_2.','.$arq_3.','.$arq_4.','.$arq_y;

            $arp_1 = '(rp_1+rp_2+rp_3) as arp_1';
            $arp_2 = '(rp_4+rp_5+rp_6) as arp_2';
            $arp_3 = '(rp_7+rp_8+rp_9) as arp_3';
            $arp_4 = '(rp_10+rp_11+rp_12) as arp_4';
            $arp_y = '(rp_1+rp_2+rp_3+rp_4+rp_5+rp_6+rp_7+rp_8+rp_9+rp_10+rp_11+rp_12) as arp_y';
            $arp = $arp_1.','.$arp_2.','.$arp_3.','.$arp_4.','.$arp_y;

            $aoq_1 = '(oq_1+oq_2+oq_3) as aoq_1';
            $aoq_2 = '(oq_4+oq_5+oq_6) as aoq_2';
            $aoq_3 = '(oq_7+oq_8+oq_9) as aoq_3';
            $aoq_4 = '(oq_10+oq_11+oq_12) as aoq_4';
            $aoq_y = '(oq_1+oq_2+oq_3+oq_4+oq_5+oq_6+oq_7+oq_8+oq_9+oq_10+oq_11+oq_12) as aoq_y';
            $aoq = $aoq_1.','.$aoq_2.','.$aoq_3.','.$aoq_4.','.$aoq_y;

            $aqs_1 = '(q_1+q_2+q_3) as aqs_1';
            $aqs_2 = '(q_4+q_5+q_6) as aqs_2';
            $aqs_3 = '(q_7+q_8+q_9) as aqs_3';
            $aqs_4 = '(q_10+q_11+q_12) as aqs_4';
            $aqs_y = '(q_1+q_2+q_3+q_4+q_5+q_6+q_7+q_8+q_9+q_10+q_11+q_12) as aqs_y';
            $aqs = $aqs_1.','.$aqs_2.','.$aqs_3.','.$aqs_4.','.$aqs_y;

            $aps_1 = '(p_1+p_2+p_3) as aps_1';
            $aps_2 = '(p_4+p_5+p_6) as aps_2';
            $aps_3 = '(p_7+p_8+p_9) as aps_3';
            $aps_4 = '(p_10+p_11+p_12) as aps_4';
            $aps_y = '(p_1+p_2+p_3+p_4+p_5+p_6+p_7+p_8+p_9+p_10+p_11+p_12) as aps_y';
            $aps = $aps_1.','.$aps_2.','.$aps_3.','.$aps_4.','.$aps_y;

            $arn_1 = '(rn_1+rn_2+rn_3) as arn_1';
            $arn_2 = '(rn_4+rn_5+rn_6) as arn_2';
            $arn_3 = '(rn_7+rn_8+rn_9) as arn_3';
            $arn_4 = '(rn_10+rn_11+rn_12) as arn_4';
            $arn_y = '(rn_1+rn_2+rn_3+rn_4+rn_5+rn_6+rn_7+rn_8+rn_9+rn_10+rn_11+rn_12) as arn_y';
            $arn = $arn_1.','.$arn_2.','.$arn_3.','.$arn_4.','.$arn_y;

            $arz_1 = '(rz_1+rz_2+rz_3) as arz_1';
            $arz_2 = '(rz_4+rz_5+rz_6) as arz_2';
            $arz_3 = '(rz_7+rz_8+rz_9) as arz_3';
            $arz_4 = '(rz_10+rz_11+rz_12) as arz_4';
            $arz_y = '(rz_1+rz_2+rz_3+rz_4+rz_5+rz_6+rz_7+rz_8+rz_9+rz_10+rz_11+rz_12) as arz_y';
            $arz = $arz_1.','.$arz_2.','.$arz_3.','.$arz_4.','.$arz_y;

            $arx_1 = '(rx_1+rx_2+rx_3) as arx_1';
            $arx_2 = '(rx_4+rx_5+rx_6) as arx_2';
            $arx_3 = '(rx_7+rx_8+rx_9) as arx_3';
            $arx_4 = '(rx_10+rx_11+rx_12) as arx_4';
            $arx_y = '(rx_1+rx_2+rx_3+rx_4+rx_5+rx_6+rx_7+rx_8+rx_9+rx_10+rx_11+rx_12) as arx_y';
            $arx = $arx_1.','.$arx_2.','.$arx_3.','.$arx_4.','.$arx_y;
        }
        
        

        switch ($out) {
            case '' :
                $s = '*,(' . substr($s, 0, strlen($s) - 1) . ') as nakop,(' .
                    substr($s1, 0, strlen($s1) - 1) . ') as nakop_s,(' .
                    substr($s2, 0, strlen($s2) - 1) . ') as nakop_o,(' .
                    substr($s3, 0, strlen($s3) - 1) . ') as nakop_q,(' .
                    substr($s4, 0, strlen($s4) - 1) . ') as nakop_p,(' .
                    substr($s5, 0, strlen($s5) - 1) . ') as nakop_n,(' .
                    substr($s6, 0, strlen($s6) - 1) . ') as nakop_z,(' .
                    substr($s7, 0, strlen($s7) - 1) . ') as nakop_x,(' .
                    substr($s8, 0, strlen($s8) - 1) . ') as nakop_v'.','.
                    $arq.','.$arp.','.$aoq.','.$aqs.','.$aps.','.$arn.','.$arz.','.$arx;
                break;
            case 'nakop_q' :
                $s = '(' . substr($s3, 0, strlen($s3) - 1) . ')';
                break;
            case 'nakop_v' :
                $s = '(' . substr($s8, 0, strlen($s8) - 1) . ')';
                break;
            case 'nakop_z' :
                $s = '(' . substr($s6, 0, strlen($s6) - 1) . ')';
                break;
            case 'nakop_o' :
                $s = '(' . substr($s2, 0, strlen($s2) - 1) . ')';
                break;
            case 'nakop_n' :
                $s = '(' . substr($s5, 0, strlen($s5) - 1) . ')';
                break;
            case 'nakop' :
                $s = '(' . substr($s, 0, strlen($s) - 1) . ')';
                break;
        }
        return $s;

    }
}
