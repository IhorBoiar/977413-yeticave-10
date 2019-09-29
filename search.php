<?php
require_once("helpers.php");
require_once("functions.php");

$con = mysqli_connect("localhost", "root", "", "yeticave5");
mysqli_set_charset($con, "utf8");

if(!$con) {
    echo "ERROR";
}

$sql_cat = "SELECT * FROM categories";
$result_cat = mysqli_query($con, $sql_cat);
$categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);

$search = mysqli_real_escape_string($con, $_GET['search']) ?? '';

if ($search) {
    $sql = "SELECT l.id AS id_lot, l.name AS name_lot, price, img, c.name AS name_cat, time_exit
     FROM lots l 
    JOIN categories c ON c.id = l.category_id WHERE MATCH(l.name, description) AGAINST('$search')";
    $result = mysqli_query($con, $sql);
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);  
    if (mysqli_num_rows($result) == 0) { 
        $search_page = include_template("error.php", [
            'error_message' => "Ничего не найдено по вашему запросу...",
            'categories' => $categories,
        ]);   
    } else {
        $search_page = include_template("search.php", [
            'lots' => $lots,
            'categories' => $categories,
            'search' => $search,
        ]);    
    }
}  elseif(!$search) {
    $search_page = include_template("error.php", [
        'error_message' => "Ничего не найдено по вашему запросу...",
        'categories' => $categories,
    ]); 
}

$layout_page = include_template("layout.php", [
    'content' => $search_page,
     'user_name' => $user_name,
     'is_auth' => $is_auth,
     'categories' => $categories,
     'title' => 'Поиск',
    ]);

print($layout_page);