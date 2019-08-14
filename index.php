<?php
// require_once("templates/layout.php");
// require_once("templates/main.php");


function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!file_exists($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

$main_page = include_template("main.php", ['items' => $items, 'categories' => $categories]);
$layout_page = include_template("layout.php", ['content' => $main_page, 'title' => $user_name]);

print($layout_page);
