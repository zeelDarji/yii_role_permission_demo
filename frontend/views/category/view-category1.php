<?php

use frontend\models\Category;

function fetchCategoryTreeList($parent = NULL, $user_tree_array = '')
{

    if (!is_array($user_tree_array)) {
        $user_tree_array = array();
    }

    $result = Category::find()->where(['parent_id' => $parent])->orderBy(['category_id' => SORT_ASC])->all();
    $count = count($result);

    if ($count > 0) {
        $user_tree_array[] = "<ul>";
        foreach ($result as $row) {
            $user_tree_array[] = "<li>" . $row->category_name . "</li>";
            $user_tree_array = fetchCategoryTreeList($row->category_id, $user_tree_array);
        }
        $user_tree_array[] = "</ul>";
    }
    return $user_tree_array;
}

?>
<ul>
    <?php
    $res = fetchCategoryTreeList();
    foreach ($res as $r) {
        echo $r;
    }
    ?>
</ul>