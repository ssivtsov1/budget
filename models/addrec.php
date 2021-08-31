<?php
/* Ввод основных данных для ввода новой строки бюджета */

namespace app\models;

use Yii;
use yii\base\Model;

class Addrec extends Model
{
   
    public $typetmc;
    public $type_act;
    public $page;
    public $vid_repair;
    public $spec;
    public $ed_izm;
    public $name_obj;
    public $price;
    public $dname_obj;
    public $name_tmc;
    public $isNewRecord;

    public function attributeLabels()
    {
        return [
            'typetmc' => 'Вид ТМЦ:',
            'type_act' => 'Вид діяльності:',
            'dname_obj' => 'Дисп. назва обʼекта',
            'ed_izm' => 'Од.вим.',
            'price' => 'Ціна',
            'spec' => 'Розділ закупівель',
            'vid_repair' => 'Вид ремонту',
            'page' => 'Стаття бюджету',
            'name_obj' => 'Назва обʼєкту',
            'name_tmc' => 'Товар',
        ];
    }

    public function rules()
    {
        return [

            [['typetmc','dname_obj','ed_izm','isNewRecord','type_act',
                'price','spec','vid_repair','page','name_obj','name_tmc'],'safe']
            ];

    }

}
