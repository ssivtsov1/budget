<?php
/**
 * Используется для отображения груп товаров
 */
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
//use app\models\User;
//use app\models\Status_project;

class Spr_spec extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'spr_spec';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'name_spec' => 'Розділ закупівель',


               ];
    }
    public function rules()
    {
        return [
            [['id',
                'name_spec'],'safe'
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


