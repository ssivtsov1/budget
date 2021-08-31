<?php
/**
 * Используется для отображения единиц измерений
 */
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
//use app\models\User;
//use app\models\Status_project;

class Spr_edizm extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'spr_edizm';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'ed_izm' => 'Од. вим.',


               ];
    }
    public function rules()
    {
        return [
            [['id',
                'ed_izm'],'safe'
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


