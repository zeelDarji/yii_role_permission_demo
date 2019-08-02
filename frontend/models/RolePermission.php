<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use frontend\models\Permission as permissions;
/**
 * ContactForm is the model behind the contact form.
 */
class RolePermission extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'role-permission';
    }



}
