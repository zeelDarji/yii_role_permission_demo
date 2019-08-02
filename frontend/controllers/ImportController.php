<?php


namespace frontend\controllers;

use Yii;
use frontend\models\Import;
use frontend\models\ImportedData;
use yii\web\Controller;
use yii\web\UploadedFile;

class ImportController extends Controller
{

    public function actionCreate()
    {
        $model = new Import();
        $firstRow = false;
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
//            print_r($model->file);
//            exit;

//            if ($model->file) {
//                $time = time();
//                $model->file->saveAs('csv/' . $time . '.' . $model->file->extension);
//                $model->file = 'csv/' . $time . '.' . $model->file->extension;
//            }
            $handle = fopen($model->file->tempName, "r");
            while (($fileop = fgetcsv($handle, 1000, ","))) {
                if ($firstRow == true) {
                    $data = new ImportedData();
                    $data->id_no = $fileop[0];
                    $data->name = $fileop[1];
                    $data->surname = $fileop[2];
                    $data->save();
                }
                $firstRow = true;
            }
            $model->save();
            return $this->redirect(['view']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionView()
    {
        return $this->render('view');
    }
}