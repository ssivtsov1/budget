<?php
/**
 * Используется для отображения видов ремонтов
 */
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
//use app\models\User;
//use app\models\Status_project;

class Spr_typerepair extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'spr_typerepair';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'vid_repair' => 'Вид ремонту',


               ];
    }
    public function rules()
    {
        return [
            [['id',
                'vid_repair'],'safe'
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


