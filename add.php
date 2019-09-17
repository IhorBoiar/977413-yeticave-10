<?php
require_once("functions.php");
require_once("helpers.php");
require_once("data.php");

$con = mysqli_connect("localhost", "root", "", "yeticave5");
mysqli_set_charset($con, "utf8");

if(!$con) {
    echo "ERROR";
}
// подключение к базе данных

$sql_cat = "SELECT * FROM categories";
$result_cat = mysqli_query($con, $sql_cat);
$categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$lot = $_POST;

	$required = ['lot-name', 'message', 'lot-date'];
    $errors = [];
    
    $rules = [
        'message' => function() {
            return validateLenght('message', 20, 1000);
        },
        'lot-rate' => function() {
            return validateRate('lot-rate');
        },
        'lot-step' => function() {
            return validateStep('lot-step');
        },
        'lot-date' => function() {
            return validateDate('lot-date');
        }
    ];

    foreach($_POST as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule();
        }
    }

    
    $errors = array_filter($errors);
        
        foreach ($required as $key) {
            if (empty($_POST[$key])) {
                $errors[$key] = 'Это поле надо заполнить';
            }
        }

        if (isset($_FILES['img'])) {
            $file_name = $_FILES['img']['name'];
            $file_path = __DIR__ . '/uploads/';
            $size = $_FILES['img']['size'];
            
            move_uploaded_file($_FILES['img']['tmp_name'], $file_path . $file_name);
            $img = './uploads/' . $file_name;
            
            $type_img = mime_content_type($img);
            

                if ($type_img != 'image/jpeg' && $type_img != 'image/jpg' && $type_img != 'image/png')
                 {
                     $errors['img'] = "Вы не загрузили картинку или выбрали неправильний формат(формат должен быть - JPG, JPEG, PNG)";
                 } elseif ($size > 5000000) {
                    $errors['img'] = "Максимальный размер - 5М";
                }
        //          else {
        //             $lot['img'] = $file_name;
        //         }

        // } else {
        //     $errors['img'] = 'Вы не загрузили файл.';
        // 
    }
        if (count($errors)) {
            $add_page = include_template('add.php', ['errors' => $errors, 'categories' => $categories]);
        }

        else {
                
                $lot_name = $_POST['lot-name'];
                $category = $_POST['category'];
                $message = $_POST['message'];
                $img = 'uploads/' . $_FILES['img']['name'];
                $lot_rate = $_POST['lot-rate'];
                $lot_step = $_POST['lot-step'];
                $lot_date = $_POST['lot-date'];


        
                $sql_insert = "INSERT INTO `lots` (`name`, `description`, `price`, `img`, `category_id`,
                `time_exit`, `user_id`, `winner_id`, `round_of_bet`)
                VALUES ('$lot_name', '$message', '$lot_rate', '$img', '$category', '$lot_date', 1, 2, '$lot_step')";
                $result_ins = mysqli_query($con, $sql_insert);
                
                $new_lot = mysqli_insert_id($con);
   
                if ($new_lot) {
                header('Location: lot.php?id=' . $new_lot);
            }
        }

    }

    else {
        $add_page = include_template("add.php", [
            'categories' => $categories,
         ]);
    }

 $layout_page = include_template("layout.php",[
    'content' => $add_page,
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'categories' => $categories,
    'title' => 'Добавить лот',
    ]);

print($layout_page);