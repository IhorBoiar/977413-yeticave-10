<?php
require_once("helpers.php");
require_once("functions.php");


$sql_cat = "SELECT * FROM categories";
$result_cat = mysqli_query($con, $sql_cat);
$categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);

$sign_in_page = isset($sign_in_page);

if (isset($_SESSION['email'])) {
    http_response_code(403);
    
    $error = include_template("error.php", [
        'error_message' => 'Вы уже вошли на сайт...',
        'categories' => $categories,
    ]);
    
    $error_page = include_template("layout.php", [
        'content' => $error,
        'categories' => $categories,
        'title' => 'Вы уже вошли на сайт',
        ]);
    
    print($error_page);

} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);                           

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
        } elseif(isset($password)) {
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
            
            $ses_email = $_SESSION['email'];
            $ses_password = $_SESSION['password'];
            $ses_name = $_SESSION['name'];

            header('Location: /');

        } else {
            $sign_in_page = include_template("login.php", [
                'categories' => $categories,
                'errors' => $errors,
            ]);
        }
                    
    } else {
        $sign_in_page = include_template("login.php", [
            'categories' => $categories,
        ]);        
    }

    $layout_page = include_template("layout.php", [
        'content' => $sign_in_page,
        'categories' => $categories,
        'title' => 'Вход',
        ]);

    print($layout_page);
}