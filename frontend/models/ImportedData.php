<?php


namespace frontend\models;


use yii\db\ActiveRecord;

class ImportedData extends ActiveRecord
{

    public static function tableName()
    {
        return 'imported-data';
    }
}