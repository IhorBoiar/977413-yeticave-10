<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");


$main_page = include_template("main.php", [
    'items' => $items,
    'categories' => $categories,
    'last_date' => $last_date,
 ]);

$layout_page = include_template("layout.php", [
    'content' => $main_page,
     'user_name' => $user_name,
     'is_auth' => $is_auth,
     'categories' => $categories,
     'title' => 'Главная',
    ]);

print($layout_page);