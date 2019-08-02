<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Permission Assign Form';
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="row">
    <div class="col-lg-5">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Permission</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $form = ActiveForm::begin(['id' => 'assignRoleToPermissionForm']);
            foreach ($model as $mod): ?>
                <?php
                echo HTML::checkBox('Permission[' . $mod['id'] . ']', true, array('label' => $mod['permissionName']));
                ?>
                <!--                    <td>--><?php //echo $form->field($mod, 'Permission['.$mod['id'].']')->CheckBox(['id'=>$mod['permissionName'], 'value' => $mod['id']])->label($mod['permissionName'] ); ?><!--</td>-->
            <?php

            endforeach;
            ?>
            <input type="hidden" class="class-control" name="roleId" value="<?= Yii::$app->request->get('id'); ?>">
            <td><?= Html::submitButton('Submit', ['role', 'id' => $mod['id'], ['class' => 'btn btn-primary btn-sm', 'style' => 'margin:5px;']]) ?>
            </td>
            <?php
            ActiveForm::end();
            ?>
            </tbody>
        </table>
    </div>
</div>
