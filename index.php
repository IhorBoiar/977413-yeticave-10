<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");

$con = mysqli_connect("localhost", "root", "", "yeticave5");
mysqli_set_charset($con, "utf8");

if(!$con) {
    echo "ERROR";
}

$sql_lots = "SELECT l.id AS id_lot, l.name AS name_l, price, img, c.name AS name_c, time_exit FROM lots l 
JOIN categories c ON c.id = l.category_id
ORDER BY dt_add DESC LIMIT 9";
$result_lots = mysqli_query($con, $sql_lots);
$items = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);

$sql_cat = "SELECT * FROM categories";
$result_cat = mysqli_query($con, $sql_cat);
$categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);


$main_page = include_template("main.php", [
    'items' => $items,
    'categories' => $categories,
 ]);

$layout_page = include_template("layout.php", [
    'content' => $main_page,
     'user_name' => $user_name,
     'is_auth' => $is_auth,
     'categories' => $categories,
     'title' => 'Главная',
    ]);

print($layout_page);