<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Role-Permission Form';
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="row">
    <div class="col-lg-5">

        <table class="table">
            <thead>
            <tr>
                <th scope="col">Role</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($model as $mod): ?>
                <tr>
                    <td><?php echo $mod['role_id']; ?></td>
                    <td><?= Html::a('<span class="btn-label">Assign Permission</span>', ['assign-permission', 'id' => $mod['id']], ['class' => 'btn btn-primary btn-sm','style' => 'margin:5px;']) ?><?= Html::a('<span class="btn-label">View Permission</span>', ['view-permission', 'id' => $mod['id']], ['class' => 'btn btn-primary btn-sm','style' => 'margin:5px;']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

