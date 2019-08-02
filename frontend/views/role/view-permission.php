<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'View-Permission Form';
?>
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Permission</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($joinModel as $mod): ?>
                    <tr>
                        <td><?php echo $mod['permission_id']?></td>
                        <td><?php echo $mod['permissionName']?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php
