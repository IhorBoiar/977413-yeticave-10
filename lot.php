<?php
require_once("functions.php");
require_once("helpers.php");

$id = mysqli_real_escape_string($con, $_GET['id']);
$sql_lot = "SELECT *, l.name AS name_lot, c.name AS name_cat FROM lots l
               JOIN categories c ON c.id = l.category_id
               WHERE l.id = " . $id;
$result_lot = mysqli_query($con, $sql_lot);
$lot = mysqli_fetch_assoc($result_lot);

$sql_cat = "SELECT * FROM categories";
$result_cat = mysqli_query($con, $sql_cat);
$categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);


$sql_bets = "SELECT *, date AS date_bet,  u.name AS name_user FROM bets b
            JOIN users u ON u.id = b.user_id WHERE lot_id = $id ORDER BY date DESC";
$result_bets = mysqli_query($con, $sql_bets);
$bets = mysqli_fetch_all($result_bets, MYSQLI_ASSOC);

            
$sql_select_price_1 = "SELECT price FROM bets WHERE lot_id = $id ORDER BY id DESC LIMIT 1";
$res_select_price_1 = mysqli_query($con, $sql_select_price_1);        
$last_bets_1 = mysqli_fetch_assoc($res_select_price_1);

$last_bet = (int)$last_bets_1['price'];
    
$start_price = (int)$lot['price'];
$step_lot = (int)$lot['round_of_bet'];
$min_bet_1 = $start_price + $step_lot;
$min_bet_2 = $last_bet + $step_lot;

if (!empty($last_bet)) {
    $new_price = $last_bet;    
} else {
    $new_price = (int)$lot['price'];
}
// $bet_step = $price_lot + $step_lot;

// $bet_step_2 = $start_price + $step_lot;

$id_user = $_SESSION['id'];
$sql_creater = "SELECT u.id AS id_user, l.id AS id_lot, l.user_id AS lot_user_id FROM lots l
                JOIN users u ON u.id = l.user_id 
                WHERE l.id = $id";
$res_creater = mysqli_query($con, $sql_creater);
$creater = mysqli_fetch_assoc($res_creater);
$creater = $creater['lot_user_id'];

if ($id_user == $creater) {
    $true = TRUE;
} else {
    $true = FALSE;
}

$sql_beter = "SELECT user_id FROM bets b
JOIN users u ON u.id = b.user_id 
WHERE b.lot_id = $id ORDER BY date DESC";
$res_beter = mysqli_query($con, $sql_beter);
$beter = mysqli_fetch_assoc($res_beter);
$beter = $beter['user_id'];

if ($id_user == $beter) {
    $done = TRUE;
} else {
    $done = FALSE;
}

$errors = [];


if(!empty($lot))  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $required = ['cost'];

        foreach ($required as $key) {
            if (empty($_POST[$key])) {
                $errors[$key] = 'Это поле надо заполнить';
            }
        }
        $step = mysqli_real_escape_string($con, $_POST['cost']);
        $int_step = (int)$step;
        $price = mysqli_real_escape_string($con, $_POST['cost']);
        // var_dump($price);

        if ($int_step <= 0) {
                $errors['cost'] = "Число должно быть больше нуля.";
            } elseif(!is_int($int_step)) {
                $errors['cost'] = "Число должно быть целым.";
            }
            
            if (strlen($int_step) > 7) {
                $errors['cost'] = "Не более 7 цифр.";     
            }
             
            if ($int_step < $min_bet_1 or $int_step < $min_bet_2) {
                $errors['cost'] = "Ставка должна быть више цены на $step_lot рублей";
            }
        
            if (!ctype_digit($price)) {
                $errors['cost'] = "Используйте только цифри.";
            }
        
            
        if (empty($errors)) {
            
            $email = $_SESSION['email'];
            $sql_user = "SELECT id FROM users WHERE email= '$email'";
            $res_user = mysqli_query($con, $sql_user);
            $user = mysqli_fetch_assoc($res_user);
            $user_id = $user['id'];

            $sql_delete = "DELETE FROM bets WHERE user_id = $user_id AND lot_id = $id ORDER BY date DESC LIMIT 1";
            $res_delete_bet = mysqli_query($con, $sql_delete);
            
            $sql_ins_bet = "INSERT INTO `bets`(`price`, `user_id`, `lot_id`) VALUES ('$price', '$user_id', '$id')";
            $res_ins_bet = mysqli_query($con, $sql_ins_bet);
                   
            // $sql_new_price = "SELECT price FROM bets WHERE lot_id = $id ORDER BY id DESC LIMIT 1";
            // $res_new = mysqli_query($con, $sql_new_price);        
            // $new_price_1 = mysqli_fetch_assoc($res_new);
            
            $sql_select_price_1 = "SELECT price FROM bets WHERE lot_id = $id ORDER BY id DESC LIMIT 1";
            $res_select_price_1 = mysqli_query($con, $sql_select_price_1);        
            $last_bets_1 = mysqli_fetch_assoc($res_select_price_1);
            
            $last_bet = (int)$last_bets_1['price'];
            

            $start_price = (int)$lot['price'];
            $step_lot = (int)$lot['round_of_bet'];
           

            if (!empty($price)) {
                $new_price = $last_bet;   
                $min_bet_2 = $new_price + $step_lot; 
            }

            

            $sql_bets = "SELECT *, date AS date_bet, u.name AS name_user FROM bets b
                        JOIN users u ON u.id = b.user_id WHERE lot_id = $id ORDER BY date DESC";
            $result_bets = mysqli_query($con, $sql_bets);
            $bets = mysqli_fetch_all($result_bets, MYSQLI_ASSOC);
       



            $id_user = $_SESSION['id'];
            $sql_beter = "SELECT user_id FROM bets b
                            JOIN users u ON u.id = b.user_id 
                            WHERE b.lot_id = $id ORDER BY date DESC";
            $res_beter = mysqli_query($con, $sql_beter);
            $beter = mysqli_fetch_assoc($res_beter);
            $beter = $beter['user_id'];
            var_dump($beter);


            if ($id_user == $beter) {
                $done = TRUE;
            } else {
                $done = FALSE;
            }


            // $sql_beter = "SELECT u.id, email, b.user_id, b.lot_id FROM users u
            //               JOIN bets b ON u.id = b.user_id  
            //                 WHERE email= '$email'";
            // $res_beter = mysqli_query($con, $sql_beter);
            // $beter = mysqli_fetch_assoc($res_beter);
            // $beter_email = $beter['email'];

        }

    }

    $lot_page = include_template("lot.php", [
    'categories' => $categories,
    'errors' => $errors,
    'lot' => $lot,
    'last_bet' => $last_bet,
    'new_price' => $new_price,
    'start_price' => $start_price,
    'bets' => $bets,
    'min_bet_1' => $min_bet_1,
    'min_bet_2' => $min_bet_2,
    'true' => $true,
    'done' => $done,
    ]);
    
    $layout_page = include_template("layout.php", [
        'content' => $lot_page,
        'categories' => $categories,
        'title' => $lot['name_lot'],
        ]); 
    
print($layout_page);    
} else {
    http_response_code(404);
    
    $error = include_template("error.php", [
        'error_message' => 'Такого лота не существует...',
        'categories' => $categories,
    ]);
    
    $error_page = include_template("layout.php", [
        'content' => $error,
        'categories' => $categories,
        'title' => 'Нету данной страницы',
        ]);
    print($error_page);
}