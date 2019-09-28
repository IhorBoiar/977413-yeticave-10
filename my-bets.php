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
 time_exit, l.name AS name_lot, c.name AS name_cat, u.contacts AS cont_user, winner_id FROM bets b 
JOIN lots l ON b.lot_id = l.id
JOIN categories c ON l.category_id = c.id
JOIN users u ON l.user_id = u.id 
WHERE b.user_id = $id_user ORDER BY date DESC";



// SELECT *
//   FROM <YOUR_TABLE>
//  WHERE (user, page_id, time) IN
//     (
//     SELECT  user, page_id, MAX(time) time
//       FROM <YOUR_TABLE>
//     GROUP BY user, page_id
//    )


// "SELECT b.user_id AS id_user, l.id AS id_lot, 
// DATE_FORMAT(date, '%d.%m.%y в %H:%i') AS date_bet, b.price AS price_bet, img,
//  time_exit, l.name AS name_lot, c.name AS name_cat FROM lots l
//             LEFT JOIN (SELECT lot_id, price(MAX) AS max_price
//              FROM bets AS bet
//              GROUP BY lot_id
//              ON l.id = bet.lot_id
             
//              LEFT JOIN bets AS b 
//              ON l.id = b.lot_id
//              AND b.price = bet.max_price
             
//              LEFT JOIN categories AS c
//              ON l.category_id = c.id
             
//              WHERE l.time_exit <= NOW()
//              AND l.winner_id IS NULL
//              AND bet.max_price IS NOT NULL"

// inner join (
//     select username, max(date) as MaxDate
//     from MyTable
//     group by username
// ) tm on t.username = tm.username and t.date = tm.MaxDate

$result_bets = mysqli_query($con, $sql_bets);
$bets = mysqli_fetch_all($result_bets, MYSQLI_ASSOC);

// $sql_lots_creater = "SELECT user_id, u.name AS name_user, u.contacts AS cont_user FROM lots l
//                      JOIN users u ON u.id = l.user_id";
// $res_lots_creater = mysqli_query($con, $sql_lots_creater);
// $creater = mysqli_fetch_assoc($res_lots_creater)['cont_user'];


// var_dump($sql_bets);

if (mysqli_num_rows($result_bets) >= 1) {
$my_bets_page = include_template("my-bets.php", [
    'categories' => $categories,
    'bets' => $bets,
    'id_user' => $id_user,
    
]); 
} else {
$my_bets_page = include_template("error.php", [
        'error_message' => "Вы ёще не ставили ни одной ставки.",
        'categories' => $categories,
    ]); 

}

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