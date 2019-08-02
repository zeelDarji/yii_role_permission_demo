<?php

namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class Blog extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'blog';
    }
    public function getUser()
    {
        return $this->hasOne(User::className(),['id' => 'author_id']);
    }
    public function rules()
    {
        return [

//            ['content', 'required'],

        ];
    }

    public function attributeLabels()
{
    return [
//        'id' => 'Id',
//        'content' => 'Content',
    ];
}


}
