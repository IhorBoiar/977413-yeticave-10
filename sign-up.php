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


// print("Email: " . $_POST['email']);
// print("<br>Password: " . $_POST['password']);
// print("<br>Name: " . $_POST['name']);
// print("<br>Message: " . $_POST['message']);
// print("<br>Errors: " . $errors['email']);

// $email = $_POST['email'];
// $sql_email = "SELECT * FROM users WHERE email = " . $email;
// $res_email = mysqli_query($con, $sql_email);

// print(var_dump($sql_email));
// echo "<br>";
// print(var_dump($res_email));


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    

	$required = ['email', 'password', 'name', 'message'];
    $errors = [];

    $rules = [
        'password' => function() {
            return validateLenght('password', 6, 20);
        },
        'message' => function() {
            return validateLenght('message', 10,300);
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
   
    $email = $_POST['email'];
    $email_valid = filter_var($email, FILTER_VALIDATE_EMAIL);
    // $sql_email = "SELECT * FROM users WHERE email = " . $email;
    // $res_email = mysqli_query($con, $sql_email);
    
    
    if(!$email_valid) {
        $errors['email'] = "Введите свой email корректно.";
    } 
    // elseif($res_email) {
        // $errors['email'] = "Такой email уже существует!";
    // }


    
    if(empty($errors)) {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $contacts = $_POST['message'];

                $sql_user_insert = "INSERT INTO `users` (`name`, `email`, `password`, `contacts`)
                VALUES ('$name', '$email', '$password', '$contacts')";
                $res_us_ins = mysqli_query($con, $sql_user_insert);           

                if ($res_us_ins) {
                header('Location: sign-in.php');
            } 
        }
     else {
    
        $sign_up_page = include_template("sign-up.php", [
            'categories' => $categories,
            'errors' => $errors,
        ]);    
    }
}
  else {


        $sign_up_page = include_template("sign-up.php", [
            'categories' => $categories,
        ]);
    }

$layout_page = include_template("layout.php", [
    'content' => $sign_up_page,
     'user_name' => $user_name,
     'is_auth' => $is_auth,
     'categories' => $categories,
     'title' => 'Регистрация',
    ]);

print($layout_page);
