<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
echo $form->field($model, 'file')->fileInput() ;
echo Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ;

ActiveForm::end();
