<?php


namespace frontend\controllers;

use common\models\User;
use frontend\components\CategoryView;
use \frontend\controllers\CategoryController;
use frontend\models\Blog;
use frontend\models\BlogCategory;
use frontend\models\Category;
use frontend\models\UserRole;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\helpers\Json;

class BlogController extends Controller
{
    use CategoryView;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['add-blog', 'view-blog'],
                'rules' => [
                    [
                        'actions' => ['add-blog', 'view-blog'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionAddBlog()
    {

        $model = new Blog();
        $blogCategoryModel = new BlogCategory();
        $categoryModel = Category::find()->select('category_id as id, category_name as title,parent_id')->asArray()->all();
        $dataset = Yii::$app->request->post();
        $categoryDropdown = Yii::$app->request->post('BlogCategory');

//        $categoryDropdown = Yii::$app->request->post('categoryDropdown'); //Multi Select DropDown
        if (Yii::$app->request->post()) {
            $dateRange = $dataset['Blog']['to_date'];
            if (!empty($dateRange)) {
                $date = explode(' - ', $dateRange);
                $model->to_date = $date[0];
                $model->from_date = $date[1];
            }
            $model->author_id = Yii::$app->user->getId();
            $model->description = htmlentities($dataset['description']);
            $model->title = $dataset['title'];
            $model->save();
            $categoryDropdown = $categoryDropdown['category_id'];
            $categoryDropdown = explode(',',$categoryDropdown);
//                print_r($categoryDropdown);
//            exit;

            foreach ($categoryDropdown as $k=>$category) {
                $res = Category::find()->where(['category_name' => $category])->all();
//                echo '<pre>';
//                print_r($res);
//                exit;
                $blogCategoryModel = new BlogCategory();
                $blogCategoryModel->blog_id = $model['id'];
                $blogCategoryModel->category_id = $category;
                $blogCategoryModel->save();
            }
//            exit;

            Yii::$app->session->setFlash('success', 'Successfully Updated.');
            return $this->redirect('view-blog');
        } else {
            return $this->render('add-blog', [
                'model' => $model,
                'blogCategoryModel' => $blogCategoryModel,
                'categoryTree' => $this->buildTree($categoryModel),
            ]);
        }
    }

    public function actionViewBlog()
    {
//        $res = Yii::$app->request->post();
//            echo '<pre>';
//            print_r($res);
//            exit;
//        $user = Yii::$app->user->identity->username;
        $model = new Blog();
        $categoryModel = Category::find()->select('category_id as id, category_name as title ,parent_id')->asArray()->all();
        $dataPackage = Blog::find()
//          ->select('blog.*')
            ->joinWith('user', '`user`.`id` = `blog`.`author_id`')
//            ->where(['between',"date('Y-m-d')",'to_date','from_date'])->createCommand()->getRawSql();
            ->all();
        $user = User::find()->all();
        $listData = ArrayHelper::map($user, 'id', 'username');
        return $this->render('view-blog', [
            'dataPackage' => $dataPackage,
            'listData' => $listData,
            'categoryModel' => $categoryModel,
            'categoryTree' => $this->buildTree($categoryModel),
            'model' => $model,
        ]);
    }

    public function actionViewDynamicBlog()
    {
        $authorId = Yii::$app->request->post('author_id');
        exit;
        $dynamicData = Blog::find()->where(['author_id' => $authorId])->joinWith('user', '`user`.`id` = `blog`.`author_id`')
            ->asArray()
            ->all();
        return Json::Encode($dynamicData);
    }

}