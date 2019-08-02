<?php


namespace frontend\controllers;


use frontend\models\Category;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use Yii;

class CategoryController extends Controller
{

    public function actionAddCategory()
    {
        try {
            $model = new Category();
            $categoryModel = Category::find()->asArray()->all();
            $categoryNames = array(NULL=>'Parent Category');
            foreach ($categoryModel as $category) {
                $categoryNames[$category['category_id']] =  $category['category_name'];
//                array_push($categoryNames, $category['category_name']);
            }
            if(Yii::$app->request->post()){
                $dataset = Yii::$app->request->post();
                $model->category_name = $dataset['Category']['category_name'];
                $model->parent_id = $dataset['Category']['category_id'];
                $model -> save();
                return $this->redirect('view-category');
            }
            else{
                return $this->render('add-category',
                    [   'model' => $model,
                        'categoryNames' => $categoryNames
                    ]);
            }
        }
        catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    public function actionViewCategory()
    {
        //select all rows from the category table
        $categories = Category::find()->asArray()->all();
        foreach ($categories as $category){
            if(empty($category['parent_id'])){
                $parents[] = $category;
            }
            else{
                $childs[] = $category;
            }

        }
        foreach ($parents as $parent){
            foreach ($childs as $key => $child){
                if($parent['category_id'] === $child['parent_id']){
                    $parent[$parent['category_id']][] = $child;
                    unset($childs[$key]);
                }
            }
            $categoryTree[] = $parent;

        }
        if(count($childs) > 0){

            foreach ($categoryTree as $key => $ct){
                foreach ($ct[$ct['category_id']] as $key => $parent1){
                    foreach ($childs as $key => $child){
                        if($parent1['category_id'] === $child['parent_id']){
                            $parent1[$parent1['category_id']][] = $child;
                            unset($childs[$key]);
                        }
                    }
                    $ct[$ct['category_id']][] = $parent1;
                }
                $categoryTree2[] = $ct;

            }
            $categoryTree3 = $this->iterateChild($categoryTree, $childs);


        }
        echo '<pre>';
        print_r($categoryTree3);
//        print_r($parent);
//        print_r($child);
        exit;

//create a multidimensional array to hold a list of category and parent category
//        $category = array(
//            'categories' => array(),
//            'parent_cats' => array()
//        );

//build the array lists with data from the category table
//        foreach ($result as $row){
//            //creates entry into categories array with current category id ie. $categories['categories'][1]
//            $category['categories'][$row['category_id']] = $row;
//            //creates entry into parent_cats array. parent_cats array contains a list of all categories with children
//            $category['parent_cats'][$row['parent_id']][] = $row['category_id'];
//        }
//        echo '<pre>';
//        print_r($category);
//        foreach ($result as $row){
//            foreach ($category['parent_cats'] as $cat_id) {
//            foreach ($cat_id as $cat_val) {
//                echo $cat_val == $row['category_id'] ? $row['category_name'] : '';
//            }
//            }
//            echo '->';
////        }
//        exit;
        return $this->render('view-category',
            [

            ]);
    }

    public function iterateChild($categoryTree, $childs)
    {
        foreach ($categoryTree as $key => $ct){
            foreach ($ct[$ct['category_id']] as $key => $parent1){
                foreach ($childs as $key => $child){
                    if($parent1['category_id'] === $child['parent_id']){
                        $parent1[$parent1['category_id']][] = $child;
                        unset($childs[$key]);
                    }
                }
                $ct[$ct['category_id']][] = $parent1;
            }
            $categoryTree2[] = $ct;

        }
        return $categoryTree2;

    }
}

