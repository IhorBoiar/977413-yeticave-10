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

// $sql_lots = "SELECT l.id AS id_lot, l.name AS name_l, price, img, c.name AS name_c, time_exit FROM lots l 
// JOIN categories c ON c.id = l.category_id";
// $result_lots = mysqli_query($con, $sql_lots);
// $bets = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);

$id_user = $_SESSION['id'];
$sql_bets = "SELECT b.user_id AS id_user, l.id AS lot_id, 
DATE_FORMAT(date, '%d.%m.%y в %H:%i') AS date_bet, b.price AS price_bet, img,
 time_exit, l.name AS name_lot, c.name AS name_cat FROM bets b 
JOIN lots l ON b.lot_id = l.id
JOIN categories c ON l.category_id = c.id WHERE b.user_id = $id_user ORDER BY date DESC";

$result_bets = mysqli_query($con, $sql_bets);
$bets = mysqli_fetch_all($result_bets, MYSQLI_ASSOC);



// var_dump($sql_bets);

$my_bets_page = include_template("my-bets.php", [
    'categories' => $categories,
    'bets' => $bets,
]);

$layout_page = include_template("layout.php", [
'content' => $my_bets_page,
 'user_name' => $user_name,
 'is_auth' => $is_auth,
 'categories' => $categories,
 'title' => 'Мои ставки',
]);

// print("<br> Email: " . $email);
// print("<br> Password: " . $password_2);
// print("<br> Errors: " . var_dump($errors));
// print("<br> PasswordVef: " . $passwordVerify);
    
print($layout_page);