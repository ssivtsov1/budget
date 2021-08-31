<?php
/**
 * Используется для редактирования остатков РЭС
 */
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use app\models\User;

class Tmc_res extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'tmc_res';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Дата',
            'txt' => 'Запис',
            'id_project' => 'Проект',
            'status' => 'Статус проекта',
            'username' => 'Користувач',
            'id_klient' => 'Користувач'
               ];
    }
    public function rules()
    {
        return [
            [['id','id_klient','id_project','date',
                'txt'],'safe'
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


