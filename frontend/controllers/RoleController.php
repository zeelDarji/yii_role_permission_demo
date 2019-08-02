<?php


namespace frontend\controllers;

use common\models\User;
use frontend\components\CheckPermission;
use frontend\models\Role;
use frontend\models\Permission;
use frontend\models\RolePermission;
use frontend\models\UserRole;
use Yii;
use yii\base\InvalidArgumentException;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\HttpException;

class RoleController extends Controller
{

    use CheckPermission; //for permission grant

    /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['user-role-assign', 'assign-role-permission', 'assign-role', 'assign-permission', 'add-role', 'view-permission', 'view-role-permission'],
                'rules' => [
                    [
                        'actions' => ['user-role-assign', 'assign-role', 'assign-role-permission'],
                        'allow' => true,
                        'matchCallback' => $this->getPermission(),
                    ],
                    [
                        'actions' => ['assign-permission', 'add-role', 'view-permission', 'view-role-permission'],
                        'allow' => true,
                        'matchCallback' => $this->returnsPermissionResult()
                    ],
                ],
            ]
        ];
    }

    public function actionAddRole()
    {
        $model = new \frontend\models\Role();
        try {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Successfully Added.');
                return $this->redirect(['role']);
            }
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        return $this->render('add-role', [
            'model' => $model
        ]);
    }

    public function actionRole()
    {
        $model = Role::find()->asArray()->all();
        return $this->render('role', [
            'model' => $model
        ]);
    }

    public function actionEditRole($id)
    {
        try {
            $model = Role::find()->where(['id' => $id])->one();
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Successfully Updated.');
                return $this->redirect(['role']);
            }
        } catch (Exception $e) {
            throw new HttpException($e->getMessage());
        }
        return $this->render('edit-role', ['model' => $model]);
    }

    public function actionDeleteRole($id)
    {
        try {
            $model = Role::findOne($id);
            $model->delete();
        } catch (Exception $e) {
            throw new HttpException($e->getMessage());
        }
        Yii::$app->session->setFlash('success', 'Successfully Deleted.');
        return $this->redirect(['role']);
    }

    public function actionAssignPermission($id)
    {
        try {
            $requestData = Yii::$app->request;
            $requestPermission = $requestData->post('Permission');//Form submitted then it has data
            $requestRoleId = $requestData->post('roleId');
            if (!empty($requestPermission)) {
                foreach ($requestPermission as $permissionId => $requestPermissionBool) {
                    $model = new RolePermission();
                    $model->permission_id = $permissionId;
                    $model->role_id = $requestRoleId;
                    $model->save();
                    Yii::$app->session->setFlash('success', 'Successfully Added.');
                    return $this->redirect(['role']);
                }
            } else {
                $roleModel = \frontend\models\Role::find()->where(['id' => $id])->one();
                $model = Permission::find()->all();
                return $this->render('assign-permission', [
                    'model' => $model,
                    'roleModel' => $roleModel,
                ]);
            }
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }


    public function actionViewPermission($id)
    {
        $joinModel = RolePermission::find()->where(['role_id' => $id])->select('role-permission.*,permission.permissionName, role.roleName')
            ->leftJoin('permission', '`permission`.`id` = `role-permission`.`permission_id`')
            ->leftJoin('role', '`role`.`id` = `role-permission`.`role_id`')
            ->asArray()->all();
//        $model = RolePermission::find()->where(['role_id' => $id])->all();
        return $this->render('view-permission', [
            'joinModel' => $joinModel
        ]);
    }

    public function actionViewRolePermission()
    {
        $model = RolePermission::find()->asArray()->all();
        return $this->render('view-role-permission', [
            'model' => $model
        ]);
    }

    public function actionAssignRolePermission()
    {
        try {
            $roleModel = Role::find()->asArray()->all();
            $permissionModel = Permission::find()->asArray()->all();
            $rolePermissionModel = RolePermission::find()->asArray()->all();
            $data = Yii::$app->request->post();
            if (!empty($data)) {
                $dataset = $data['role_permission'];
                Yii::$app->db->createCommand()->truncateTable('role-permission')->execute();
                foreach ($dataset as $permissionId => $role) {
                    foreach ($role as $roleId => $status) {
                        $rolePermission = new RolePermission();
                        $rolePermission->permission_id = $permissionId;
                        $rolePermission->role_id = $roleId;
                        $rolePermission->save();
                    }
                }
                return $this->redirect('view-assign-role-permission');
            }
        }
    catch (InvalidArgumentException $e) {
        throw new BadRequestHttpException($e->getMessage());
    }
        return $this->render('assign-role-permission', [
            'roleModel' => $roleModel,
            'permissionModel' => $permissionModel,
            'rolePermissionModel' => $rolePermissionModel
        ]);

    }

    public function actionViewAssignRolePermission()
    {

        return $this->render('view-assign-role-permission');
    }

    public function actionUserRoleAssign()
    {
        $model = User::find()->asArray()->all();
        return $this->render('user-role-assign',
            [
                'model' => $model
            ]);
    }

    public function actionAssignRole($id)
    {
        try {
            $userRoleModel = UserRole::find()->where(['user_id' => $id])->asArray()->all();
            $model = Role::find()->asArray()->all();
            $userRoleArray = array();
            foreach ($userRoleModel as $userRole) {
                array_push($userRoleArray, $userRole['role_id']);
            }
            if (Yii::$app->request->post()) {
                $data = Yii::$app->request->post();
                $roledata = array_keys($data);
                array_shift($roledata); //removes first element from array
                foreach ($roledata as $role) {
                    if (!in_array($role, $userRoleArray)) {
                        $model = new UserRole();
                        $model->role_id = $role;
                        $model->user_id = $id;
                        $model->save();
                    }
                }
                return $this->redirect('user-role-assign');
            }
        }
    catch (InvalidArgumentException $e) {
        throw new BadRequestHttpException($e->getMessage());
    }
        return $this->render('assign-role', [
            'model' => $model,
            'userRoleArray' => $userRoleArray,
            'userRoleModel' => $userRoleModel,
            'id' => $id
        ]);
    }

}