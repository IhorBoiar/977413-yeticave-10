<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");


$ses_email = $_SESSION['email'];
$ses_password = $_SESSION['password'];
$ses_name = $_SESSION['name'];

$con = mysqli_connect("localhost", "root", "", "yeticave5");
mysqli_set_charset($con, "utf8");

if(!$con) {
    echo "ERROR";
}

$sql_cat = "SELECT * FROM categories";
$result_cat = mysqli_query($con, $sql_cat);
$categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);

$email = $_POST['email'];
$password = $_POST['password'];
               


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    

	$required = ['email', 'password'];
    $errors = [];
    
    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }

    $errors = array_filter($errors);
   
    $select_email = "SELECT * FROM `users` WHERE `email` = '$email'";
    $result_email = mysqli_query($con, $select_email);
    

    if (mysqli_num_rows($result_email) == 0) {
        $errors['email'] = "Нет такого пользователя";
    } elseif($password) {
        $user = mysqli_fetch_assoc($result_email);
        $password_2 = $user['password'];
        $passwordVerify = password_verify($password, $password_2);
        if (!$passwordVerify) {
            $errors['password'] = "Вы ввели неправильный пароль";
        }
    }
        if(empty($errors)) {
                $_SESSION['email'] = $_POST['email'];
                $_SESSION['password'] = $_POST['password'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['id'] = $user['id'];
                

                header('Location: /');

                // $_SESSION['name'] = $password_1['name'];
                // $ses_name = $_SESSION['name'];
                    } else {
                        $_SESSION = [];
                        $sign_up_page = include_template("login.php", [
                            'categories' => $categories,
                            'errors' => $errors,
                        ]);
                    }
                
                
                // if($result_email) {
                //     $password = mysqli_fetch_all($result_email, MYSQLI_ASSOC);
                //     foreach ($password as $passwordHash) {
                //         $passwordHash = $passwordHash['password'];
                //     }
                // $passwordVerify = password_verify($password, $passwordHash); 
                //     if($passwordVerify) {
                //         header('Location: /');
                //     } else {
                //         $errors['password'] = "Неправильный пароль!";
                //     }
                // }
        } 
     else {
        
        $sign_up_page = include_template("login.php", [
            'categories' => $categories,
        ]);
        
    }

    $layout_page = include_template("layout.php", [
        'content' => $sign_up_page,
         'user_name' => $user_name,
         'is_auth' => $is_auth,
         'categories' => $categories,
         'title' => 'Вход',
        ]);

        // print("<br> Email: " . $email);
        // print("<br> Password: " . $password_2);
        // print("<br> Errors: " . var_dump($errors));
        // print("<br> PasswordVef: " . $passwordVerify);
            
    print($layout_page);
    
    