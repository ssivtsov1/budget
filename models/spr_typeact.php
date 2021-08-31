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

class Spr_typeact extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'spr_typeact';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'type_act' => 'Тип діяльності',


               ];
    }
    public function rules()
    {
        return [
            [['id',
                'type_act'],'safe'
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


