<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("vendor/autoload.php");




$con = mysqli_connect("localhost", "root", "", "yeticave5");
mysqli_set_charset($con, "utf8");

if(!$con) {
    echo "ERROR";
}

$sql_time = "SELECT l.id AS lot_id, l.name AS name_lot, time_exit FROM lots l";
$result_time = mysqli_query($con, $sql_time);
$times = mysqli_fetch_all($result_time, MYSQLI_ASSOC);


// echo '<pre>';
//   print_r($times);
// echo '</pre>';



foreach ($times as $time) {
$time_exit = get_dt_range($time['time_exit']); 
$hour = $time_exit[0];
$min = $time_exit[1];

// echo "<br>" . $hour . " : " . $min;
// echo '<pre>';
//   print_r( $time_exit );
// echo '</pre>';
if ($hour <= 0 AND $min <= 0) {
    // $winner = $time['id_user']
    // 
    $lot_id = $time['lot_id'];
    $sql_win = "SELECT u.id, u.name, email, price FROM users u
                JOIN bets b ON u.id = b.user_id
                WHERE lot_id = $lot_id ORDER BY id DESC LIMIT 1";
    $res_win = mysqli_query($con, $sql_win);        
    $win = mysqli_fetch_assoc($res_win);

    $winner = $win['id'];
    $winner_name = $win['name'];
    $winner_login = $win['email'];
    
    $recipients = [];

    $name_lot = $time['name_lot'];
//     echo "<br>ss" . $winner;
//     echo '<pre>';
//   print_r( $win );
// echo '</pre>';

    // var_dump($res_win);
    if ($res_win) {
        $sql_add_winner = "UPDATE lots SET winner_id = $winner WHERE id = $lot_id";
        $res_add_winner = mysqli_query($con, $sql_add_winner);
        
        $transport = new Swift_SmtpTransport("phpdemo.ru", 25);
        $transport->setUsername("keks@phpdemo.ru");
        $transport->setPassword("htmlacademy");

        $mailer = new Swift_Mailer($transport);

        

        $message = new Swift_Message();
        $message->setSubject("Поздравляем с победой!");
        $message->setFrom(['keks@phpdemo.ru' => 'YetiCave']);
        $message->setBcc($recipients);

        $recipients[$winner_name] = $winner_login;

        $msg_content = include_template('email.php', [
            'winner_name' => $winner_name,
            'name_lot' => $name_lot,
            'lot_id' => $lot_id,
            ]);
        $message->setBody($msg_content, 'text/html');
    }
}
}
             
//     $res_new = mysqli_query($con, $sql_new_price);        
//     $new_price_1 = mysqli_fetch_assoc($res_new);
    
//     $price_lot = (int)$new_price_1['price'];

//     $step_lot = (int)$lot['round_of_bet'];
//     $bet_step = $price_lot + $step_lot;

//     $items[$key]['bet_step'] = $bet_step;
// }   






// $sql_winner = "SELECT * FROM bets b
//                 JOIN lots";
// $result_winner = mysqli_query($con, $sql_cat);
// $winner = mysqli_fetch_all($result_cat, MYSQLI_ASSOC); -->
