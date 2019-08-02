<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Assign Role Vise Permission Form';

$roleIds = array_column($rolePermissionModel,'role_id');
$premissionIds = array_column($rolePermissionModel,'premission_id');
?>
<div class="row">
    <div class="col-lg-12">
        <table class="table">
            <thead>
            <tr>
                <?php $form = ActiveForm::begin(['id' => 'assignRoleVisePermissionForm']); ?>
                <th>
                    <?php foreach ($roleModel as $role): ?>
                <th><?php echo $role['roleName'] ?></th>
            <?php endforeach; ?>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 0;
            foreach ($permissionModel as $permission): ?>
                <tr>
                    <th><?php
                        $permissionName = array_column($permissionModel, 'permissionName');
                        echo $permissionName[$i];
                        $i++; ?>
                    </th>
                    <?php foreach ($roleModel as $role):
                        $checked = '';
                        foreach ($rolePermissionModel as $rolePermissionKey => $rolePermissionValue){
                            if($rolePermissionValue['role_id'] === $role['id'] && $rolePermissionValue['permission_id'] === $permission['id'])
                             $checked = 'checked';
                        }
                        ?>
                        <td><input type="checkbox" name="role_permission[<?= $permission['id'] ?>][<?= $role['id'] ?>]"
                                <?= $checked; ?>
                            >
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'Submit']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
