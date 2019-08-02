<?php

use frontend\models\Category; ?>


<?php
function recursive($categoryTree, $level = 0)
{
    foreach ($categoryTree as $key => $value) {
        if (!is_array($value) && $key == "title") {
            echo str_repeat("&nbsp;", $level), "[" . $value . "]", '';
        }

        if (is_array($value)) {
            recursive($value, $level + 1);
        } else {
            if ($key == "title") {
//                            echo "[/".$value."]", '<br>';
                echo '<br>';
            }
        }
    }
}

$tree_2 = recursive($categoryTree);
echo $tree_2;

function delete_col(&$categoryTree, $offset)
{
    return array_walk($categoryTree, function (&$v) use ($offset) {
            array_splice($v, $offset, 1);
    });
}
delete_col($categoryTree, 2);

?>

<div class="row">
    <div class="col-lg-3 pull-right">
        <script src=<?php echo 'https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js' ?>></script>
        <script src=<?php echo "https://code.jquery.com/jquery-1.12.4.min.js"?>
                integrity= <?php echo "sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" ?>
                crossorigin="anonymous">
        </script>
        <script src=<?php echo "../js/Drop-Down-Combo-Tree/comboTreePlugin.js"?>></script>
        <script src=<?php echo"../js/Drop-Down-Combo-Tree/icontains.js" ?>></script>

        <input type="text" id="example" placeholder="Select">


        <script>$('#example').comboTree({
                source : <?php echo json_encode( $categoryTree ) ?>,
                isMultiple: true
            });
        </script>
    </div>
</div>
