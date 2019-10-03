<?php
require_once("helpers.php");
require_once("functions.php");
require_once("getwinner.php");



$cur_page = $_GET['page'] ?? 1;
$page_items = 9;

$res_pages = mysqli_query($con, "SELECT COUNT(*) as cnt FROM lots WHERE winner_id IS NULL");
$items_count = mysqli_fetch_assoc($res_pages)['cnt'];

$pages_count = ceil($items_count / $page_items);
$offset = ($cur_page - 1) * $page_items;

$sql_lots = "SELECT l.id AS id_lot, l.name AS name_l, l.price AS lot_price, img, c.name AS name_c, time_exit, round_of_bet, price FROM lots l 
JOIN categories c ON c.id = l.category_id
WHERE winner_id IS NULL
ORDER BY dt_add DESC LIMIT $page_items OFFSET $offset";
$result_lots = mysqli_query($con, $sql_lots);
$items = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);

foreach ($items as $key => $item) {
    $item_id = $item['id_lot'];

    $sql_new_price = "SELECT price FROM bets WHERE lot_id = $item_id ORDER BY id DESC LIMIT 1";            
    $res_new = mysqli_query($con, $sql_new_price);        
    $new_price = mysqli_fetch_assoc($res_new);
    
    $price_lot = (int)$item['price'];
    $step_lot = (int)$item['round_of_bet'];
    $new_step = (int)$new_price['price'];

    $bet_step = $new_step;
    $items[$key]['bet_step'] = $bet_step; 
}   


$sql_cat = "SELECT * FROM categories";
$result_cat = mysqli_query($con, $sql_cat);
$categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);

$main_page = include_template("main.php", [
    'items' => $items,
    'categories' => $categories,
    'pages_count' => $pages_count,
    'cur_page' => $cur_page,
    'page_items' => $page_items,     
 ]);

$layout_page = include_template("layout.php", [
    'content' => $main_page,
     'categories' => $categories,
     'title' => 'Главная',
    ]);

print($layout_page);