<?php

use Carbon\Carbon;
use App\Category;

function be64($id) {
    return base64_encode($id);
}

function bd64($id) {
    return base64_decode($id);
}

function getCategoryTree($level = 0, $prefix = '') {
    $rows=  Category::where('parent_id', $level)->orderBy('id','asc')->get();
    $category = '';
    if (!$rows->isEmpty()) {
        foreach ($rows as $row) {
            $category .= $prefix . $row->name . "\n";
            // Append subcategories
            $category .= $this->getCategoryTree($row->id, $prefix . '-');
        }
    }
    return $category;
}
function recursiveElements($data) {
    $elements = [];
    $tree = [];
    foreach ($data as &$element) {
        $element['children'] = [];
        $id = $element['id'];
        $parent_id = $element['parent_id'];
        $elements[$id] =& $element;
        if (isset($elements[$parent_id])) { $elements[$parent_id]['children'][] =& $element; }
        else { $tree[] =& $element; }
    }
    return $tree;
}

function flattenDown($data, $index=0) {
    $elements = [];
    foreach($data as $element) {
        $elements[] = '<option value="'.$element['id'].'">'.str_repeat('-', $index) . $element['name'].'</option>';
        if(!empty($element['children'])) $elements = array_merge($elements, flattenDown($element['children'], $index+1));
    }
    return $elements;
}
?>