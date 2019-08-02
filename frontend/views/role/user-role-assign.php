<?php
use yii\db\ActiveRecord;
use yii\widgets\ActiveForm;
use yii\helpers\Html; ?>

<div class="row">
    <div class="col-lg-8">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Role</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($model as $mod): ?>
                <tr>
                    <td><?php echo $mod['username']; ?></td>
                    <td><?= Html::a('<span class="btn-label">Assign Role</span>', ['assign-role', 'id' => $mod['id']], ['class' => 'btn btn-primary btn-sm']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
