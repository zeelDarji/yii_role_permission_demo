<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\Users;
use kartik\export\ExportMenu;
use yii\data\ActiveDataProvider;

$this->title = 'User Form';
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="row">
    <div class="col-lg-5">

        <?= Html::a('<span class="btn-label">Add</span>', ['add-user'], ['class' => 'btn btn-primary']) ?>
        <?= $exportWidget ?>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Image</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($model as $mod): ?>
                <tr>
                    <td><?php echo $mod['name']; ?></td>
                    <td><img src="../uploads/<?php echo $mod['image'];?>" style="height: 100px; width: 100px;"></td>
                    <td><?= Html::a('<span class="btn-label">Edit</span>', ['edit', 'id' => $mod['id']], ['class' => 'btn btn-primary btn-sm','style' => 'margin:5px;']) ?><?= Html::a('<span class="btn-label">Delete</span>', ['delete', 'id' => $mod['id']], ['class' => 'btn btn-primary btn-sm','style' => 'margin:5px;']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
