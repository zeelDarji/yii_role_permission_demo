<?php


namespace frontend\controllers;

use frontend\components\CategoryView;
use frontend\models\Category;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use Yii;

class CategoryController extends Controller
{
use CategoryView;
    public function actionAddCategory()
    {
        try {
            $model = new Category();
            $categoryModel = Category::find()->asArray()->all();
            $categoryNames = array(NULL => 'Parent Category'); //For Dropdown list
            foreach ($categoryModel as $category) {
                $categoryNames[$category['category_id']] = $category['category_name']; //Generate array with key cat_id and value cat_name
//                array_push($categoryNames, $category['category_name']);
            }
            if (Yii::$app->request->post()) {
                $dataset = Yii::$app->request->post();
                $model->category_name = $dataset['Category']['category_name'];
                $model->parent_id = $dataset['Category']['category_id'];
                $model->save();
                return $this->redirect('view-category');
            } else {
                return $this->render('add-category',
                    ['model' => $model,
                        'categoryNames' => $categoryNames,
                        'categoryModel' => $categoryModel
                    ]);
            }
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }
    public function actionViewCategory()
    {
        $categoryModel = Category::find()->select('category_id as id, category_name as title,parent_id')->asArray()->all();
        return $this->render('view-category', [
            'categoryModel' => $categoryModel,
            'categoryTree' => $this->buildTree($categoryModel),
        ]);
    }
}

