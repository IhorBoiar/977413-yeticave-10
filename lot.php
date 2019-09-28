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
$sql_lot = "SELECT *, l.name AS name_lot, c.name AS name_cat FROM lots l
               JOIN categories c ON c.id = l.category_id
               WHERE l.id = " . $safe_id;
$result_lot = mysqli_query($con, $sql_lot);
$lot = mysqli_fetch_assoc($result_lot);

// var_dump($id_lots); // проверка
$sql_cat = "SELECT * FROM categories";
$result_cat = mysqli_query($con, $sql_cat);
$categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);


$sql_bets = "SELECT *, DATE_FORMAT(date, '%d.%m.%y в %H:%i') AS date_bet,  u.name AS name_user FROM bets b
            JOIN users u ON u.id = b.user_id WHERE lot_id = $safe_id";
$result_bets = mysqli_query($con, $sql_bets);
$bets = mysqli_fetch_all($result_bets, MYSQLI_ASSOC);

            
$sql_select_price_1 = "SELECT price FROM bets WHERE lot_id = $safe_id ORDER BY id DESC LIMIT 1";
            $res_select_price_1 = mysqli_query($con, $sql_select_price_1);        
            $last_bets_1 = mysqli_fetch_assoc($res_select_price_1);
            $price_lot = (int)$last_bets_1['price'];
    
            $step_lot = (int)$lot['round_of_bet'];
            $bet_step = $price_lot + $step_lot;

            $start_price = (int)$lot['price'];
            $bet_step_2 = $start_price + $step_lot;


// ///////////////////////////////////////////////////////////////////
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $required = ['cost'];
//     $errors = [];
    
    // $rules = [
    //     'cost' => function() {
    //         return validateStep('cost');
    //     }
    // ];

    // foreach($_POST as $key => $value) {
    //     if (isset($rules[$key])) {
    //         $rule = $rules[$key];
    //         $errors[$key] = $rule();
    //     }
    // }

// var_dump($errors);
    // foreach ($required as $key) {
    //     if (empty($_POST[$key])) {
    //         $errors[$key] = 'Это поле надо заполнить';
    //     }
    // }

    // $errors = array_filter($errors);

    //     $lot_id = $_GET['id'];
    //     $price = $_POST['cost'];
    //     $email = $_SESSION['email'];
    //     $sql_user = "SELECT id FROM users WHERE email= '$email'";
    //     $res_user = mysqli_query($con, $sql_user);
    //     $user = mysqli_fetch_assoc($res_user);
    //     $user_id = $user['id'];
    

    //     $sql_ins_bet = "INSERT INTO `bets`(`price`, `user_id`, `lot_id`) VALUES ('$price', '$user_id', '$safe_id')";
    //     $res_ins_bet = mysqli_query($con, $sql_ins_bet);
////////////////////////////////////////////////
if($lot)  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $required = ['cost'];
        $errors = [];

        foreach ($required as $key) {
            if (empty($_POST[$key])) {
                $errors[$key] = 'Это поле надо заполнить';
            }
        }
        $step = mysqli_real_escape_string($con, $_POST['cost']);
        // $step = $_POST['cost'];
        $int_step = (int)$step;
        $price = mysqli_real_escape_string($con, $_POST['cost']);

        if ($int_step <= 0) {
                $errors['cost'] = "Число должно быть больше нуля.";
            } elseif(!is_int($int_step)) {
                $errors['cost'] = "Число должно быть целым.";
            }
            if (strlen($int_step) > 7) {
                $errors['cost'] = "Не более 7 цифр.";     
            }


            
            
            if ($int_step < $bet_step or $int_step < $bet_step_2) {
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
        // ////
            $sql_delete = "DELETE FROM bets WHERE user_id = $user_id AND lot_id = $safe_id ORDER BY date DESC LIMIT 1";
            $res_delete_bet = mysqli_query($con, $sql_delete);
            
            $sql_ins_bet = "INSERT INTO `bets`(`price`, `user_id`, `lot_id`) VALUES ('$price', '$user_id', '$safe_id')";
            $res_ins_bet = mysqli_query($con, $sql_ins_bet);
            
//                 
            $sql_new_price = "SELECT price FROM bets WHERE lot_id = $safe_id ORDER BY id DESC LIMIT 1";
            
            $res_new = mysqli_query($con, $sql_new_price);        
            $new_price_1 = mysqli_fetch_assoc($res_new);
            
            $price_lot = (int)$new_price_1['price'];
    
            $step_lot = (int)$lot['round_of_bet'];
            $bet_step = $price_lot + $step_lot;
            

            // echo "что вишло";
            // var_dump($bet_step);
            // ////////////////////
            
            $sql_bets = "SELECT *, DATE_FORMAT(date, '%d.%m.%y в %H:%i') AS date_bet, u.name AS name_user FROM bets b
                        JOIN users u ON u.id = b.user_id WHERE lot_id = $safe_id";
            $result_bets = mysqli_query($con, $sql_bets);
            $bets = mysqli_fetch_all($result_bets, MYSQLI_ASSOC);
        }
    }

    // $price_lot = (int)$last_bets_1['price'];
                
    // $step_lot = (int)$lot['round_of_bet'];
    // $bet_step = $price_lot + $step_lot;

            
        // $lot_id = $_GET['id'];
            
        // $sql_select_price = "SELECT price FROM bets WHERE lot_id = $lot_id ORDER BY id DESC LIMIT 1";
        // $res_select_price = mysqli_query($con, $sql_select_price);        
        // $last_bets = mysqli_fetch_assoc($res_select_price);
        // $last_bet = $last_bets['price'];

//      if ($int_step > $bet_step) {
//         $price_lot = (int)$lot['price'];
//         $step_lot = (int)$lot['round_of_bet'];
//         $bet_step = $price_lot + $step_lot;
//         $new_price = $int_step;
        
    
// }
// echo "что было";
          
    // var_dump($price_lot);
//     echo "<br>";
//     var_dump($price_lot);
//     echo "<br>";
//     var_dump($step_lot);
    // echo "<br>";
    // var_dump($bet_step);

    $lot_page = include_template("lot.php", [
    'categories' => $categories,
    'lot' => $lot,
    'errors' => $errors,
    'bet_step' => $bet_step,
    'price_lot' => $price_lot,
    'last_bet' => $last_bet,
    'bets' => $bets,
        ]);
    
    $layout_page = include_template("layout.php", [
        'content' => $lot_page,
        'user_name' => $user_name,
        'is_auth' => $is_auth,
        'categories' => $categories,
        'title' => $lot['name'],
        ]);
    
print($layout_page);    
} else {
    http_response_code(404);
    
    $error = include_template("error.php", [
        'error_message' => 'Такого лота не существует...',
    ]);
    
    $error_page = include_template("layout.php", [
        'content' => $error,
        'user_name' => $user_name,
        'is_auth' => $is_auth,
        'categories' => $categories,
        'title' => 'Error',
        ]);
    print($error_page);
    }