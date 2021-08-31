<?php
/**
 * Используется для отображения объектов
 */
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
//use app\models\User;
//use app\models\Status_project;

class Spr_obj extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'spr_obj';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'name_obj' => 'Назва обʼєкта',


               ];
    }
    public function rules()
    {
        return [
            [['id',
                'name_obj'],'safe'
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


