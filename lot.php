<?php
include_once 'functions.php'; // подключаем файл функций
// переменные
//$is_auth = rand(0, 1);
//$user_name = 'Anton';
$title = 'Главная страница';
$value = 'tomorrow midnight';
session_start();
// запрос в БД
$con = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($con, "utf8");
$errors['price_bet']='';

if (isset($_GET['id']) and !empty($_GET['id'])) //проверка существования параметра
{
    $id = intval($_GET['id']);
} else {
    http_response_code(404);
    $page404 = include_template('404.php', []);
    die($page404);
}

$sql = "SELECT name_category from categories";

if ($res = mysqli_query($con, $sql)) {
    $rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
} else {
    $error = mysqli_connect_error();
    die('Unknown error');
}

$sql = "SELECT lot_name, picture, first_price, description, name_category, price_step  FROM lots l 
JOIN categories c ON l.category_id = c.id
WHERE l.id = $id";
if ($res = mysqli_query($con, $sql)) {
    $param = mysqli_fetch_all($res, MYSQLI_ASSOC);
    if (empty($param)) {
        http_response_code(404);
        $page404 = include_template('404.php', []);
        die($page404);
    }
} else {
    http_response_code(404);
    $page404 = include_template('404.php', []);
    die($page404);
}

 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $required = ['price_bet'];
    $dict = ['price_bet' => 'Ваша ставка'];
    $errors = [];
    $price = $param[0]['first_price'] + $param[0]['price_step']; 

    if (empty($_POST['price_bet'])) {  //проверка заполнения формы 
    $errors['price_bet'] = 'Это поле надо заполнить';
    }

    //проверка числа 
     if (!(int)($_POST['price_bet']) and !empty($_POST['price_bet'])) {
    $errors['price_bet'] = 'Введите числовое значение';
    } 

      if ((int)($_POST['price_bet']) and (int)($_POST['price_bet']) <= $price) {
    $errors['price_bet'] = 'Введите значение больше нуля';
    }  

    if (count($errors)){
        $sql = "SELECT name_category from categories";

        if ($res = mysqli_query($con, $sql)) {
            $rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
        } else {
            $error = mysqli_connect_error();
            die('Unknown error');
        }
        $page_content = include_template('lot.php', [
            'param' => $param,
            'value' => $value,
            'rows' => $rows,
            'id' => $id,
            'errors' => $errors
        ]);
        
        $layout_content = include_template('layout.php', [
            'page_content' => $page_content,
            'rows' => $rows,
            //'is_auth' => $is_auth,
            //'user_name' => $user_name,
            'title' => $title,
        
        ]);
        print($layout_content);

        } else {
            $praice_bet = $_POST;
            $sql = "INSERT INTO bets (bet_date, price_bet) VALUES (NOW(),?)";
            $stmt = db_get_prepare_stmt($con, $sql, [$praice_bet['price_bet']]);
            $res = mysqli_stmt_execute($stmt);

            if ($res){
                $lot_id = mysqli_insert_id($con);
                $sql = "UPDATE lots 
                SET category_id = (SELECT id FROM categories WHERE name_category = '$name_category')
                WHERE category_id IS NULL";
                $res = mysqli_query($con, $sql);
                $param = mysqli_fetch_all($res, MYSQLI_ASSOC);
                header("Location: my-bets.php");
            }
            
        }
} else { 

    $page_content = include_template('lot.php', [
        'param' => $param,
        'value' => $value,
        'rows' => $rows,
        'id' => $id,
        'errors' => $errors
        //'user_name' => $user_name,
        //'is_auth' => $is_auth,
    ]);
    $layout_content = include_template('layout.php', [
        'page_content' => $page_content,
        'rows' => $rows,
        //'is_auth' => $is_auth,
        //'user_name' => $user_name,
        'title' => $title,
    
    ]);
    print($layout_content);
}

?>