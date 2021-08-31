<?php
/* Ввод основных данных для поиска товаров */

namespace app\models;

use Yii;
use yii\base\Model;

class InputData extends Model
{
   
    public $id;
    public $rem;              // подразделение
    public $tovar;            // Товар
    public $grup;             // Группа товара
    public $kol_zak;          // Кол-во заказано
    public $kol_give;         // Кол-во выдано
    public $kol_zakup;        // Кол-во осталось купить
    public $ost_res;          // Остатки РЭС
    public $isp_res;          // Использовано РЭС
    public $zkol_zak;         // Поисковый оператор для kol_zak
    public $zkol_give;        // Поисковый оператор для kol_give
    public $zkol_zakup;       // Поисковый оператор для kol_zakup
    public $zost_res;         // Поисковый оператор для ost_res
    public $zisp_res;         // Поисковый оператор для isp_res
    public $zostn_res;
    public $zostz_res;
    public $ostn_res;
    public $ostz_res;
    public $else_repair;

    private $_user;

    public function attributeLabels()
    {
        return [
            'rem' => 'Підрозділ:',
            'tovar' => 'Товар',
            'grup' => 'Група товарів',
            'zkol_zak' => 'Кількість,замовлено',
            'zkol_give' => 'Кількість,видано',
            'zkol_zakup' => 'Кількість,докупити',
            'zost_res' => 'Отримано,РЕМ(Кільк.)',
            'zisp_res' => 'Списано,РЕМ(Кільк.)',
            'zostz_res' => 'Неотрим.,РЕМ(Кільк.)',
            'zostn_res' => 'Невикор.,РЕМ(Кільк.)',
            'kol_zak' => '',
            'kol_give' => '',
            'kol_zakup' => '',
            'ost_res' => '',
            'isp_res' => '',
            'ostn_res' => '',
            'ostz_res' => '',
        ];
    }

    public function rules()
    {
        return [

            [['ID','grup','tovar','else_repair',
                'kol_zak','kol_give','kol_zakup','ost_res','isp_res','rem','zostz_res','zostn_res',
                'zkol_zak','zkol_give','zkol_zakup','zost_res','zisp_res','ostn_res','ostz_res'],'safe']
            ];

    }

}
