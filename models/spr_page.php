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

class Spr_page extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'spr_page';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'page' => 'Статья бюджету',


               ];
    }
    public function rules()
    {
        return [
            [['id',
                'page'],'safe'
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


