<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Permission Form';
?>
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">

            <?= Html::a('<span class="btn-label">Add</span>', ['add-permission'], ['class' => 'btn btn-primary']) ?>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Permission</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($model as $mod): ?>
                    <tr>
                        <td><?php echo $mod['permissionName']; ?></td>
                        <td><?= Html::a('<span class="btn-label">Edit</span>', ['edit-permission', 'id' => $mod['id']], ['class' => 'btn btn-primary btn-sm','style' => 'margin:5px;']) ?><?= Html::a('<span class="btn-label">Delete</span>', ['delete-permission', 'id' => $mod['id']], ['class' => 'btn btn-primary btn-sm','style' => 'margin:5px;']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php
