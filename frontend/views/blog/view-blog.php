<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use \yii\helpers\Html;

?>
<script src=<?php echo 'https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js' ?>></script>
<script src=<?php echo "https://code.jquery.com/jquery-1.12.4.min.js"?>
        integrity= <?php echo "sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" ?>
        crossorigin="anonymous">
</script>
<script src=<?php echo "../js/Drop-Down-Combo-Tree/comboTreePlugin.js"?>></script>
<script src=<?php echo"../js/Drop-Down-Combo-Tree/icontains.js" ?>></script>

<div class="row">
    <?php $form = ActiveForm::begin();?>
    <div class="col-lg-5"></div>
    <div class="col-lg-3">
        <?php
        echo $form->field($model, 'author_id')->dropDownList(
            $listData,
            ['prompt' => 'Select Author', 'id' => "dropdown"])->label(false);
        ?>
    </div>
    <div class="col-lg-3 ">
        <input type="text" id="categoryDropdown"  placeholder="Select">
        <script>$('#categoryDropdown').comboTree({
                source : <?php echo json_encode( $categoryTree ) ?>,
                isMultiple: true
            });
        </script>
    </div>
    <div class="col-lg-1">
        <?php echo Html::submitButton('Apply',['class' => 'btn btn-primary', 'name' => 'categoryDropdown']) ?>
    </div>
   <?php ActiveForm::end();?>
</div>

<script>
    var categoryArray = [];
    $(document).ready(function (){
        $('.comboTreeItemTitle').on('change', function () {
            alert($(this).data("id"));
            categoryArray.push($(this).data("id"));
            console.log(categoryArray);
            $.ajax({
                url: '<?= Yii::$app->request->baseUrl . '/blog/view-blog' ?>',
                dataType: 'text',
                type: 'post',
                contentType: 'application/x-www-form-urlencoded',
                data: {'categoryDropdown': categoryArray},
            });
        });

    });
</script>

<script>
    $(document).ready(function () {
        $('#dropdown').on('change', function () {
            var html = '';
            var dropdownValue = $('#dropdown').val();
            $.ajax({
                url: '<?= Yii::$app->request->baseUrl . '/blog/view-dynamic-blog' ?>',
                dataType: 'text',
                type: 'post',
                contentType: 'application/x-www-form-urlencoded',
                data: {'author_id': dropdownValue},
                success: function (response) {
                    var data = JSON.parse(response);
                    $.each(data, function (index, value) {
                        var decodedDescription = $("<div/>").html(value.description).text();//Generate div,put encoded string into html and fetch data
                        html = html + '<div class="container"><div class="well">' +
                            '<div class="media">' +
                            '<div class="media-body">' +
                            '<h4 class="media-heading">' +
                            '' + value.title + '</h4>' +
                            '<p class="text-right">' + 'By ' + value.user.username + '</p>' +
                            '<p>' + decodedDescription + '</p>' +
                            '<ul class="list-inline list-unstyled">' +
                            '<li><span><i class="glyphicon glyphicon-calendar"></i>' + value.publish_date + '</span></li><li>|</li>' +
                            // '<li><span><i class="glyphicon glyphicon-calendar"></i>' + value.category + '</span></li></ul></div></div></div></div>';
                        console.log(html);
                    });
                    // alert(response);
                    //  var demo = $("#demo").html();
                    $("#dynamicBlogList").html(html);
                },
            });
        });
    });
</script>
<div id="dynamicBlogList">
    <?php foreach ($dataPackage as $data): ?>
        <div class="container">
            <div class="well">
                <div class="media">
                    <div class="media-body">
                        <h4 class="media-heading"><?= $data['title']; ?></h4>
                        <p class="text-right"><?= 'By ' . $data['user']['username']; ?></p>
                        <p><?= html_entity_decode($data['description']); ?></p>
                        <ul class="list-inline list-unstyled">
                            <li><span><i class="glyphicon glyphicon-calendar"></i> <?= $data['publish_date']; ?> </span>
                            </li>
                            <li>|</li>
<!--                            <li><span><i class="glyphicon glyphicon-th-list"></i> --><?//= $data['category']; ?><!-- </span></li>-->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach;
    ?>
</div>
<div id="demo" hidden>
    <h1>hello</h1>
</div>