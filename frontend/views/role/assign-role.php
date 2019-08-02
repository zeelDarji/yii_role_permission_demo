<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html; ?>
<div class="row">
    <table class="table">
        <tbody>
        <?php $form = ActiveForm::begin(); ?>
        <?php foreach ($model as $mod): ?>
            <tr>
                <td><?= $mod['roleName']?></td>
                <td><input type="checkbox" name="<?= $mod['id'] ?>"<?php echo in_array($mod['id'],$userRoleArray) ? 'checked' : '';?>></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'Submit']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>


