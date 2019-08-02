<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use dosamigos\ckeditor\CKEditor;
use kartik\daterange\DateRangePicker;
?>
<script src=<?php echo 'https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js' ?>></script>
<script src=<?php echo "https://code.jquery.com/jquery-1.12.4.min.js"?>
        integrity= <?php echo "sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" ?>
        crossorigin="anonymous">
</script>
<script src=<?php echo "../js/Drop-Down-Combo-Tree/comboTreePlugin.js"?>></script>
<script src=<?php echo"../js/Drop-Down-Combo-Tree/icontains.js" ?>></script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>A Simple Page with CKEditor</title>
    <!-- Make sure the path to CKEditor is correct -->
    <script src="<?php echo '../js/ckeditor/ckeditor.js'; ?>"></script>

</head>
<body>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'title')->textInput(['name'=>"title"]) ?>
    <?= $form->field($model, 'description')->textarea(array('name'=>"description", 'id'=>"description",'rows'=>"10", 'cols'=>"80")) ?>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($blogCategoryModel, 'category_id')->textInput(['id'=>"example"]) ?>
<!--            <input type="text" id="example" name="ex" placeholder="Select">-->
            <script>$('#example').comboTree({
                    source : <?php echo json_encode( $categoryTree ) ?>,
                    isMultiple: true
                });
            </script>
        </div>
        <div class="col-lg-6">
            <label>Pickup DateRange</label>
            <?=  DateRangePicker::widget([
                'model'=>$model,
                'attribute'=>'to_date',
                'convertFormat'=>true,
//        'options' => ['placeholder' => 'Pickup Your Date'],
                'pluginOptions'=>[
                    'timePicker'=>false,
                    'locale'=>[
                        'format'=>'Y-m-d'
                    ]
                ]
            ]); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'save']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <script>
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace( 'description',
            {
                filebrowserBrowseUrl: '../js/ckfinder/ckfinder.html',
                filebrowserImageBrowseUrl: '../js/ckfinder/ckfinder.html?type=Images',
                filebrowserUploadUrl: '../js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                filebrowserImageUploadUrl: '../js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
            });
    </script>

    <script>
        var categoryArray = [];
        $(document).ready(function (){
            $('.comboTreeItemTitle').on('change', function () {
                alert($(this).data("id"));
                categoryArray.push($(this).data("id"));
                console.log(categoryArray);
                $.ajax({
                    url: '<?= Yii::$app->request->baseUrl . '/blog/add-blog' ?>',
                    type: 'post',
                    contentType: 'application/x-www-form-urlencoded',
                    data: {'categoryDropdown': categoryArray},
                });
            });
        });
    </script>

</body>
</html>

