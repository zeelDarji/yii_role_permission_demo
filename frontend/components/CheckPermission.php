<?php

namespace frontend\components;

use frontend\models\UserRole;
use Yii;

trait CheckPermission
{
    public static function returnsPermissionResult()
    {
        return function ($rule, $action) {
            $id = Yii::$app->user->getId();
            $joinModel = UserRole::find()->where(['user_id' => $id])
                ->select('user-role.*,role-permission.*,permission.*')
                ->leftJoin('role-permission', '`role-permission`.`role_id` = `user-role`.`role_id`')
                ->leftJoin('permission', '`permission`.`id` = `role-permission`.`permission_id`')
                ->asArray()
                ->all();
            $permissionName = array_column($joinModel, 'permissionName');
            $a = array_intersect($permissionName, $rule->actions);  //Retrieve Common data from 2 array
            foreach ($a as $a1) {
                if ($a1 == Yii::$app->controller->action->id) {
                    return true;
                }
            }
        };
    }

    public static function getPermission()
    {
        return function ($rule, $action) {
            $id = Yii::$app->user->getId();
            $data = UserRole::find()
                ->where(['user_id' => $id])
                ->leftJoin('role', '`role`.`id` = `user-role`.`role_id`')
                ->select('role.*,user-role.role_id')
                ->all();
            foreach ($data as $dataset) {
                $a = in_array('7', array($dataset['id']));
                if ($a == 1) {
                    return true;
                }
            }
        };
    }

}