<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<!DOCTYPE html>
<html lang="en">
<body>
<div class="row">
    <div class="col-lg-6">
<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'category_name')->textInput(['required' => true])->label('New Category Name') ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <?= $form->field($model, 'category_id')->dropDownList($categoryNames)->label('Parent Category'); ?>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton('Add Category', ['class' => 'btn btn-primary', 'name' => 'categoryDropdown']) ?>
</div>
<?php ActiveForm::end(); ?>

</body>
</html>

