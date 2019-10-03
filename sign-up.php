<?php
require_once("helpers.php");
require_once("functions.php");

$sql_cat = "SELECT * FROM categories";
$result_cat = mysqli_query($con, $sql_cat);
$categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);

if (isset($_SESSION['email'])) {
    http_response_code(403);
    
    $error = include_template("error.php", [
        'error_message' => 'Вы уже пройшли регистрацию...',
        'categories' => $categories,
    ]);
    
    $error_page = include_template("layout.php", [
        'content' => $error,
        'categories' => $categories,
        'title' => 'Вы уже зарегестрированные',
        ]);
    
    print($error_page);
} else {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    

        $required = ['email', 'password', 'name', 'message'];
        $errors = [];

        $rules = [
            'password' => function() {
                return validateLenght('password', 6, 20);
            },
            'message' => function() {
                return validateLenght('message', 10, 300);
            },
            'name' => function() {
                return validateLenght('name', 1, 20);
            },
            'email' => function() use ($con) {
                return validateEmail('email', $con);
            }
        ];
        
        foreach ($required as $key) {
            if (empty($_POST[$key])) {
                $errors[$key] = 'Это поле надо заполнить';
            }
        }

        foreach($_POST as $key => $value) {
            if (isset($rules[$key])) {
                $rule = $rules[$key];
                $errors[$key] = $rule();
            }
        }
 
        $errors = array_filter($errors);
        $email = mysqli_real_escape_string($con, $_POST['email']);

        $email_valid = filter_var($email, FILTER_VALIDATE_EMAIL);
        $sql_email = "SELECT * FROM users WHERE email = '$email'";
        $res_email = mysqli_query($con, $sql_email);


        if(!isset($email_valid)) {
            $errors['email'] = "Введите свой email корректно.";
        } elseif (mysqli_num_rows($res_email) > 0) {
            $errors['email'] = "Такой email уже существует!";
        }
  
        if(empty($errors)) {
            $name = mysqli_real_escape_string($con, $_POST['name']);
            $password = mysqli_real_escape_string($con, $_POST['password']);

            $contacts = mysqli_real_escape_string($con, $_POST['message']);
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $sql_user_insert = "INSERT INTO `users` (`name`, `email`, `password`, `contacts`)
            VALUES ('$name', '$email', '$passwordHash', '$contacts')";
            $res_us_ins = mysqli_query($con, $sql_user_insert);           

            if (isset($res_us_ins)) {
            header('Location: login.php');
            } 
        } else {
    
            $sign_up_page = include_template("sign-up.php", [
                'categories' => $categories,
                'errors' => $errors,
            ]);    
        }
    } else {
        $sign_up_page = include_template("sign-up.php", [
            'categories' => $categories,
        ]);
    }

$layout_page = include_template("layout.php", [
    'content' => $sign_up_page,
     'categories' => $categories,
     'title' => 'Регистрация',
    ]);

print($layout_page);
}