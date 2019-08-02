<?php


namespace frontend\controllers;


use frontend\models\Users;
use kartik\export\ExportMenu;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\UploadedFile;

class UsersController extends Controller
{
    public function actionAddUser()
    {
        $model = new Users();
        if ($model->load(Yii::$app->request->post())) {
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->image && $model->validate()) {
                $model->image->saveAs('uploads/' . $model->image->baseName . '.' . $model->image->extension);
                $model->save();
            }
            Yii::$app->session->setFlash('success', 'Successfully Added.');
            return $this->redirect(['view']);
        }
        return $this->render('add-user', [
            'model' => $model
        ]);
    }


    public function actionView()
    {
        $query = Users::find();
        $model = $query->asArray()->all();
        $gridColumns = [
            [
                'class' => 'yii\grid\SerialColumn'
            ],
            'id','name','image',
            [
                'class' => 'yii\grid\ActionColumn'
            ],
        ];

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // Renders a export dropdown menu
        $exportWidget =  ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns
        ]);
        return $this->render('view', [
            'model' => $model,
            'exportWidget' => $exportWidget,
//            'dataProvider' => $dataProvider,

        ]);
    }

    public function actionEdit($id)
    {
        try {
            $model = Users::find()->where(['id' => $id])->one();
            if ($model->load(Yii::$app->request->post())) {
                $model->image = UploadedFile::getInstance($model, 'image');
                $model->image->saveAs('uploads/' . $model->image->baseName . '.' . $model->image->extension);
                $model->save();
                Yii::$app->session->setFlash('success', 'Successfully Updated.');
                return $this->redirect(['view']);
            }
        } catch (Exception $e) {
            throw new HttpException($e->getMessage());
        }
        return $this->render('edit', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        try {
            $model = Users::findOne($id);
            $model->delete();
        } catch (Exception $e) {
            throw new HttpException($e->getMessage());
        }
        Yii::$app->session->setFlash('success', 'Successfully Deleted.');
        return $this->redirect(['view']);
    }

}