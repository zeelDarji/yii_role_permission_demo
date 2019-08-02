<?php


namespace frontend\components;


trait CategoryView
{

    public static function  buildTree(array $categoryModel, $parentId = NULL)
    {

        $branch = array();

        foreach ($categoryModel as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = self::buildTree($categoryModel, $element['id']);

                if ($children) {
                    $element['subs'] = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }

}