<?php
/**
 * Используется для просмотра товаров
 */
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use app\models\User;

class Tovar extends \yii\db\ActiveRecord
{
    public $grup;
    public $name_spec;

    public static function tableName()
    {
        return 'vw_tovar';
    }

    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'grupa' => 'Група товарів',
            'grup' => 'Група товарів',
            'price' => 'Ціна',
            'tovar' => 'Товар',
            'edizm' => 'Од.вим.',
            'kol_zak' => 'Кількість,замовлено',
            'kol_give' => 'Кількість,видано',
            'kol_zakup' => 'Кількість,залишилось купити',
            'ost_res' => 'Отримано РЕМ кільк.',
            'ostp_res' => 'Отримано РЕМ (вартість тис.грн.)',
            'isp_res' => 'Списано РЕМ кільк.',
            'rem' => 'Підрозділ',

               ];
    }
    public function rules()
    {
        return [

            [['ID','grupa','grup','price','tovar','edizm','name_spec',
                'kol_zak','kol_give','kol_zakup','ost_res','isp_res','rem','ostp_res'],'safe'
            ]];
    }

    public function search($params,$sql)
    {
        $session = Yii::$app->session;
        $session->open();
        if($session->has('user'))
            $user = $session->get('user');
        else
            $user = '';

       // $query = tovar::find()->where('rem=:rem',[':rem' => $user]);
        $query = tovar::findBySql($sql);
        $query->sql = $sql;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder'=> ['rem'=>SORT_DESC]]
        ]);
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'tovar', $this->tovar]);

        return $dataProvider;
    }


    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public static function getDb()
    {
            return Yii::$app->get('db');
    }
}


