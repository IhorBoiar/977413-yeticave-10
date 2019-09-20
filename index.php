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


foreach ($items as $key => $item) {
    $item_id = $item['id_lot'];
    $sql_new_price = "SELECT price FROM bets WHERE lot_id = $item_id ORDER BY id DESC LIMIT 1";
            
    $res_new = mysqli_query($con, $sql_new_price);        
    $new_price_1 = mysqli_fetch_assoc($res_new);
    
    $price_lot = (int)$new_price_1['price'];

    $step_lot = (int)$lot['round_of_bet'];
    $bet_step = $price_lot + $step_lot;

    $items[$key]['bet_step'] = $bet_step;
}   


$sql_cat = "SELECT * FROM categories";
$result_cat = mysqli_query($con, $sql_cat);
$categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);


// $sql_price_lots = "SELECT l.price AS price_lot, b.price AS price_bet, round_of_bet FROM lots l
//                     JOIN bets b ON l.id = b.lot_id";
// $res_price_lots = mysqli_query($con, $sql_price_lots);
// $prices = mysqli_fetch_all($res_price_lots, MYSQLI_ASSOC);

// $sql_select_price_1 = "SELECT price FROM bets WHERE lot_id = $lot_id ORDER BY id DESC LIMIT 1";
//             $res_select_price_1 = mysqli_query($con, $sql_select_price_1);        
//             $last_bets_1 = mysqli_fetch_assoc($res_select_price_1);
//             $price_lot = (int)$last_bets_1['price'];
    
//             $step_lot = (int)$lot['round_of_bet'];
//             $bet_step = $price_lot + $step_lot;


$main_page = include_template("main.php", [
    'items' => $items,
    'categories' => $categories,
    'prices' => $prices,
 
    // $lot_page = include_template("lot.php", [
    //     'categories' => $categories,
    //     'lot' => $lot,
    //     'errors' => $errors,
    //         ]);
 ]);

$layout_page = include_template("layout.php", [
    'content' => $main_page,
     'user_name' => $user_name,
     'is_auth' => $is_auth,
     'categories' => $categories,
     'title' => 'Главная',
    ]);

print($layout_page);