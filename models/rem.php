<?php
/**
 * Используется для отображения РЭСов
 */
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
//use app\models\User;
//use app\models\Status_project;

class Rem extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'vw_rem';
    }

    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'rem' => 'РЕМ',


               ];
    }
    public function rules()
    {
        return [
            [['ID',
                'rem'],'safe'
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


