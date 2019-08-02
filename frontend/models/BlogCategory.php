<?php


namespace frontend\models;


use yii\db\ActiveRecord;

class BlogCategory extends ActiveRecord
{
    public static function tableName()
    {
        return 'blog-category';
    }
}