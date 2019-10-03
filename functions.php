<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "yeticave");
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

    function formatPrice_2($price) 
    {
        $price = ceil($price);
        if ($price >= 1000) {
            $price = number_format($price, 0, ',', ' ');
        }
        return $price;
    }
    
    function get_dt_range($format) 
    {
        $time_now = strtotime(date("Y-m-d H:i:s"));
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

    function getGetVal($name) {
        return $_GET[$name] ?? "";
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

        function showDate($time) { // Определяем количество и тип единицы измерения
            $time = time() - $time;
            if ($time < 60) {
              return 'меньше минуты назад';
            } elseif ($time < 3600) {
              return dimension((int)($time/60), 'i');
            } elseif ($time < 86400) {
              return dimension((int)($time/3600), 'G');
            } elseif ($time < 2592000) {
              return dimension((int)($time/86400), 'j');
            } elseif ($time < 31104000) {
              return dimension((int)($time/2592000), 'n');
            } elseif ($time >= 31104000) {
              return dimension((int)($time/31104000), 'Y');
            }
          }
          
          function dimension($time, $type) { // Определяем склонение единицы измерения
            $dimension = array(
              'n' => array('месяцев', 'месяц', 'месяца', 'месяц'),
              'j' => array('дней', 'день', 'дня'),
              'G' => array('часов', 'час', 'часа'),
              'i' => array('минут', 'минуту', 'минуты'),
              'Y' => array('лет', 'год', 'года')
            );
              if ($time >= 5 && $time <= 20)
                  $n = 0;
              else if ($time == 1 || $time % 10 == 1)
                  $n = 1;
              else if (($time <= 4 && $time >= 1) || ($time % 10 <= 4 && $time % 10 >= 1))
                  $n = 2;
              else
                  $n = 0;
              return $time.' '.$dimension[$type][$n]. ' назад';
          
          }