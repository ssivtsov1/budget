<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
//use app\models\User;
//use app\models\Status_project;

class Budget_res extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'budget_res';
    }


    public function rules()
    {
        return [
            [['id_budget',
                ],'safe'
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


