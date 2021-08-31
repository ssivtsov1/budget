<?php
/**
 * Используется для групп товаров
 */
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
//use app\models\User;
//use app\models\Status_project;

class Grup extends \yii\db\ActiveRecord
{
    public $status;

    public static function tableName()
    {
        return 'vw_tgroup';
    }

    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'grup' => 'Група',


               ];
    }
    public function rules()
    {
        return [
            [['ID',
                'grup'],'safe'
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


