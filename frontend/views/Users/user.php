<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'User Form';
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
        <?= $form->field($model, 'username') ?>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
