<?php


namespace frontend\controllers;


use frontend\models\Permission;
use frontend\models\RolePermission;
use Yii;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\HttpException;

class PermissionController extends Controller
{
    public function actionAddPermission()
    {
        $model = new Permission();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Successfully Added.');
            return $this->redirect(['permission']);
        }

        return $this->render('add-permission', [
            'model' => $model
        ]);
    }


    public function actionPermission()
    {
        $model = Permission::find()->asArray()->all();
        return $this->render('permission', [
            'model' => $model
        ]);
    }

    public function actionEditPermission($id)
    {
        try {
            $model = Permission::find()->where(['id' => $id])->one();
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Successfully Updated.');
                return $this->redirect(['permission']);
            }
        } catch (Exception $e) {
            throw new HttpException($e->getMessage());
        }
        return $this->render('edit-permission', ['model' => $model]);
    }

    public function actionDeletePermission($id)
    {
        try {
            $model = Permission::findOne($id);
            $model->delete();
        } catch (Exception $e) {
            throw new HttpException($e->getMessage());
        }
        Yii::$app->session->setFlash('success', 'Successfully Deleted.');
        return $this->redirect(['permission']);
    }


}