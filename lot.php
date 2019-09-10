<?php

require_once("functions.php");
require_once("helpers.php");
require_once("data.php");

$con = mysqli_connect("localhost", "root", "", "yeticave5");
mysqli_set_charset($con, "utf8");

if(!$con) {
    echo "ERROR";
}

$safe_id = mysqli_real_escape_string($con, $_GET['id']);
$sql_id_lot = "SELECT *, c.name AS name_cat FROM lots l
               JOIN categories c ON c.id = l.category_id
               WHERE l.id = " . $safe_id;
$result_id_lot = mysqli_query($con, $sql_id_lot);
$id_lots = mysqli_fetch_all($result_id_lot, MYSQLI_ASSOC);
// var_dump($id_lots); // проверка
$sql_cat = "SELECT * FROM categories";
$result_cat = mysqli_query($con, $sql_cat);
$categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);


if($id_lots) {

$lot_page = include_template("lot.php", [
    'categories' => $categories,
    'id_lots' => $id_lots,
 ]);

foreach ($id_lots as $lot) {
    $layout_page = include_template("layout.php", [
        'content' => $lot_page,
        'user_name' => $user_name,
        'is_auth' => $is_auth,
        'categories' => $categories,
        'title' => $lot['name'],
]);
}
print($layout_page);    
} else {
    http_response_code(404);
    
    $error = include_template("error.php");
    
    $error_page = include_template("layout.php", [
        'content' => $error,
        'user_name' => $user_name,
        'is_auth' => $is_auth,
        'categories' => $categories,
        'title' => 'Error',
    ]);
    print($error_page);
    
    die();
    
}