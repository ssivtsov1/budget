<?php
/*Ввод данных для аналитики по бюджету*/

namespace app\models;

use Yii;
use yii\base\Model;

class Analytics_ost extends Model
{
    public $type_act;         // тип деятельности
    public $type_tmc;         // Тип ТМЦ
    public $page_b;           // Статья бюджета
    public $name_service;     // Служба
    public $type_repair;      // Вид ремонта
    public $spec;             // Раздел спецификации
    public $obj;              // Название объекта
    public $name_tmc;         // Название ТМЦ

    public $gr_name_service=0;     // Служба [груп. опер.]
    public $gr_type_act=0;         // тип деятельности [груп. опер.]
    public $gr_type_tmc=0;         // Тип ТМЦ [груп. опер.]
    public $gr_n_cnt;              // Договор
    public $gr_cagent;             // Контагент
    public $gr_page_b=0;           // Статья бюджета [груп. опер.]
    public $gr_type_repair=0;      // Вид ремонта [груп. опер.]
    public $gr_spec=0;             // Раздел спецификации [груп. опер.]
    public $gr_obj=0;              // Название объекта [груп. опер.]
    public $gr_lot=0;
    public $gr_name_tmc=0;         // Название ТМЦ [груп. опер.]
    public $gr_edizm=0;           // Название единиц измирений [груп. опер.]

    public $gra_oper;          // Группировочная операция (sum,max,min ...)
    public $grh_having;        // Фильтровочно - группировочная операция (внутри having: =, >, < ...)
    public $grh_value;         // Значение внутри having
    public $grs_sort;          // Поля сортировки
    public $grs_dir;           // Направление сортировки
    public $ord='';               // Порядок группировки полей
    public $kol;

    public $gra_nakop;
    public $gra_nakop_q;
    public $gra_nakop_s;
    public $gra_nakop_z;
    public $gra_nakop_v;
    public $gra_nakop_y;
    public $gra_nakop_x;
    public $gra_nakop_n;
    public $gra_nakop_o;
    public $gra_nakop_p;
    public $sel_all;
    public $src;            //Исходный sql - запрос


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

            'gr_name_service' => 'Підрозділ:',
            'gr_type_act' => 'Тип діяльності',
            'gr_type_tmc' => 'Вид ТМЦ',
            'gr_type_repair' => 'Вид ремонту',
            'gr_page_b' => 'Стаття бюджету',
            'gr_spec' => 'Розділ закупівель',
            'gr_n_cnt' => '№ Договору',
            'gr_cagent' => 'Контрагент',
            'gr_obj' => 'Назва обʼєкту',
            'gr_lot' => 'Лот',
            'gr_name_tmc' => 'Назва ТМЦ',
            'gr_edizm' => 'Назва од. вим.',

            'gra_nakop' => 'підсумок отримано,кільк.',
            'gra_nakop_q' => 'підсумок замовлено,кільк.',
            'gra_nakop_n' => 'підсумок не використ.,кільк.',
            'gra_nakop_o' => 'підсумок списано,кільк.',
            'gra_nakop_s' => 'підсумок отримано,варт.',
            'gra_nakop_p' => 'підсумок замовлено,варт.',
            'gra_nakop_x' => 'підсумок не отримано.,варт',
            'gra_nakop_z' => 'підсумок не отримано. план,кільк',
            'gra_nakop_y' => 'підсумок не отримано. факт,кільк',
            'gra_nakop_v' => 'підсумок видано РЕМ. факт,кільк',
            'sel_all' => 'вибрати всі підсумки',
            
            'gra_arq_1' => 'отримано РЕМ 1кв.,кільк',
            'gra_arq_2' => 'отримано РЕМ 2кв.,кільк',
            'gra_arq_3' => 'отримано РЕМ 3кв.,кільк',
            'gra_arq_4' => 'отримано РЕМ 4кв.,кільк',
            'gra_arq_y' => 'отримано РЕМ за рік.,кільк',

            'gra_arp_1' => 'отримано РЕМ 1кв.,варт',
            'gra_arp_2' => 'отримано РЕМ 2кв.,варт',
            'gra_arp_3' => 'отримано РЕМ 3кв.,варт',
            'gra_arp_4' => 'отримано РЕМ 4кв.,варт',
            'gra_arp_y' => 'отримано РЕМ за рік.,варт',

            'gra_aoq_1' => 'списано РЕМ 1кв.,кільк',
            'gra_aoq_2' => 'списано РЕМ 2кв.,кільк',
            'gra_aoq_3' => 'списано РЕМ 3кв.,кільк',
            'gra_aoq_4' => 'списано РЕМ 4кв.,кільк',
            'gra_aoq_y' => 'списано РЕМ за рік.,кільк',

            'gra_arn_1' => 'не викорис. РЕМ 1кв.,кільк',
            'gra_arn_2' => 'не викорис. РЕМ 2кв.,кільк',
            'gra_arn_3' => 'не викорис. РЕМ 3кв.,кільк',
            'gra_arn_4' => 'не викорис. РЕМ 4кв.,кільк',
            'gra_arn_y' => 'не викорис. РЕМ за рік.,кільк',

            'gra_arz_1' => 'не отрим. РЕМ 1кв.,кільк',
            'gra_arz_2' => 'не отрим. РЕМ 2кв.,кільк',
            'gra_arz_3' => 'не отрим. РЕМ 3кв.,кільк',
            'gra_arz_4' => 'не отрим. РЕМ 4кв.,кільк',
            'gra_arz_y' => 'не отрим. РЕМ за рік.,кільк',

            'gra_arx_1' => 'не отрим. РЕМ 1кв.,варт',
            'gra_arx_2' => 'не отрим. РЕМ 2кв.,варт',
            'gra_arx_3' => 'не отрим. РЕМ 3кв.,варт',
            'gra_arx_4' => 'не отрим. РЕМ 4кв.,варт',
            'gra_arx_y' => 'не отрим. РЕМ за рік.,варт',

            'gra_aqs_1' => 'замовлено 1кв.,кільк',
            'gra_aqs_2' => 'замовлено РЕМ 2кв.,кільк',
            'gra_aqs_3' => 'замовлено РЕМ 3кв.,кільк',
            'gra_aqs_4' => 'замовлено РЕМ 4кв.,кільк',
            'gra_aqs_y' => 'замовлено РЕМ за рік.,кільк',

            'gra_aps_1' => 'замовлено 1кв.,варт',
            'gra_aps_2' => 'замовлено РЕМ 2кв.,варт',
            'gra_aps_3' => 'замовлено РЕМ 3кв.,варт',
            'gra_aps_4' => 'замовлено РЕМ 4кв.,варт',
            'gra_aps_y' => 'замовлено РЕМ за рік.,варт',

            'gra_oper' => 'Операція:',
            'grh_having' => 'Операція:',
            'grh_value' => 'Значення:',
            'grs_sort' => 'Поле сортування:',
            'grs_dir' => 'Вид сортування:',
            'kol' => 'Кількість:',

        ];
    }

    public function rules()
    {
        return [
            ['name_service', 'safe'],
            ['name_tmc', 'safe'],
            ['spec', 'safe'],
            ['page_b', 'safe'],
            ['type_repair', 'safe'],
            ['type_act', 'safe'],
            ['type_tmc', 'safe'],
            ['obj', 'safe'],
            ['gr_obj', 'safe'],
            ['gr_n_cnt', 'safe'],
            ['gr_cagent', 'safe'],
            ['gr_name_service', 'safe'],
            ['gr_type_act', 'safe'],
            ['gr_type_tmc', 'safe'],
            ['gr_type_repair', 'safe'],
            ['gr_page_b', 'safe'],
            ['gr_spec', 'safe'],
            ['gr_name_tmc', 'safe'],
            ['gr_edizm', 'safe'],

            ['grs_sort', 'safe'],
            ['grs_dir', 'safe'],
            ['ord', 'safe'],
            ['kol', 'safe'],
            ['gra_oper', 'safe'],
            ['grh_having', 'safe'],
            ['grh_value', 'safe'],
            ['gra_nakop','safe'],
            ['gra_nakop_q','safe'],
            ['gra_nakop_s','safe'],
            ['gra_nakop_p','safe'],
            ['gra_nakop_z','safe'],
            ['gra_nakop_x','safe'],
            ['gra_nakop_n','safe'],
            ['gra_nakop_o','safe'],
            ['gra_nakop_v','safe'],
            ['gra_nakop_y','safe'],
            ['sel_all','safe'],
            ['src','safe'],
        ];
    }

}
