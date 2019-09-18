<?php
session_start();

$_SESSION['email'];
$_SESSION['password'];
$_SESSION['name']; 

// print("ses email:" . $_SESSION['email']);
// print("<br>ses passw:" . $_SESSION['password']);
// print("<br>ses name:" . $_SESSION['name']);
// print("<br>");

// print("<br>sesion:" . var_dump($_SESSION));

$con = mysqli_connect("localhost", "root", "", "yeticave5");
mysqli_set_charset($con, "utf8");

if(!$con) {
    echo "ERROR";
} 
    function formatPrice($price) 
    {
        $price = ceil($price);
        if ($price >= 1000) {
            $price = number_format($price, 0, ',', ' ');
        }

        $price = $price . "<b class='rub'>p</b>";
        
        return $price;
    }
    
    function get_dt_range($format) 
    {
        $time_now = strtotime("2019-10-10 14:31");
        $time_last = strtotime($format);    
        
        $diff_time = $time_last - $time_now;
        $a = floor($diff_time / 3600);
        $b = floor($diff_time % 3600 / 60);

        $hours = str_pad($a, 2, "0", STR_PAD_LEFT);
        $mins = str_pad($b, 2, "0", STR_PAD_LEFT);

        $array = [$hours, $mins];
        return $array;
    }

    function getPostVal($name) {
        return $_POST[$name] ?? "";
    }

    function validateFilled($name) {
        if (empty($_POST[$name])) {
            return "Это поле должно быть заполненим.";
        }

        return NULL;
    }

    function validateLenght($name, $min, $max) {
        $len = strlen($_POST[$name]);
        if ($len < $min or $len > $max) {
            return "Значение должно быть от $min до $max символов";
        }
        
        return NULL;
   
    }


    function validateRate($name) {
        $lot_rate = $_POST[$name];
        if ($lot_rate <= 0) {
            return "Число должно быть больше нуля.";
        }
   
        return NULL;
   
    }

    function validateStep($name) {
        $lot_step = $_POST[$name];
        $int = (int)$lot_step;
        if ($int <= 0) {
            return "Число должно быть больше нуля.";
        } elseif(!is_int($int)) {
            return "Число должно быть целым.";
        }
   
        return NULL;
   
    }

    
    function validateDate($name) {
        $lot_date = $_POST[$name];
        $now = date('Y-m-d', strtotime('+1 day'));
    
        if (!is_date_valid($lot_date)) {
                return "Формат даты должен быть - 'ГГГГ-ММ-ДД'";
            } elseif (strtotime($lot_date) < strtotime($now)) {
                return "Введите действующую дату!";
            }
    
            return NULL;
   
        }
    
        function validateEmail($name, $con) {
            $email = $_POST[$name];
            $sql_email = "SELECT * FROM users WHERE email = " . $email;
            $res_email = mysqli_query($con, $sql_email);
                       
            if($res_email) {
                return $errors['email'] = "Такой email уже существует!";
            }
            return NULL;
        }
