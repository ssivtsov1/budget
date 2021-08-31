<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;

class Month extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'month'; //Это вид
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'month' => 'Місяць',
        ];
    }

    public function rules()
    {
        return [

            [['id','month'],'safe']
            ];
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


