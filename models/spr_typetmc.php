<?php
/**
 * Используется для отображения типов материалов
 */
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
//use app\models\User;
//use app\models\Status_project;

class Spr_typetmc extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'spr_typetmc';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'typetmc' => 'Вид ТМЦ',


               ];
    }
    public function rules()
    {
        return [
            [['id',
                'typetmc'],'safe'
            ]];
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


