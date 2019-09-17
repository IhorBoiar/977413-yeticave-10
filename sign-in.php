<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");

$con = mysqli_connect("localhost", "root", "", "yeticave5");
mysqli_set_charset($con, "utf8");

if(!$con) {
    echo "ERROR";
}

$sql_cat = "SELECT * FROM categories";
$result_cat = mysqli_query($con, $sql_cat);
$categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);



$sign_in_page = include_template("error.php", [
    'categories' => $categories,
 ]);

$layout_page = include_template("layout.php", [
    'content' => $sign_in_page,
     'user_name' => $user_name,
     'is_auth' => $is_auth,
     'categories' => $categories,
     'title' => 'Вход',
    ]);

print($layout_page);