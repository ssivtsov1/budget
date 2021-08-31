<?php
/**
 * Используется для отображения служб
 */
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
//use app\models\User;
//use app\models\Status_project;

class Service extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'spr_service';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'service' => 'Служба',


               ];
    }
    public function rules()
    {
        return [
            [['ID',
                'service'],'safe'
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


