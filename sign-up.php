<?php
include_once 'functions.php';
// соединение с БД
$con = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($con, "utf8");

if (empty($_POST)){
// запрос в БД
$sql = "SELECT name_category from categories";

if ($res = mysqli_query($con, $sql)) {
    $rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
} else {
    $error = mysqli_connect_error();
    die('Unknown error');
}

$page_content = include_template('sign-up.php', [
    'rows' => $rows,
]);

print($page_content);
} else {

    // валидация формы
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $sign_up = $_POST;
        $e_mail = $_POST['email'];
        $required = ['email', 'name', 'password', 'contact'];
        $dict = ['email' => 'E-mail', 'password' => 'Пароль', 'name' => 'Имя', 'contact' => 'Контактные данные'];
        $errors = [];
        $sql = "SELECT email FROM users WHERE email= '$e_mail'";
        $results = mysqli_query($con, $sql);
        $data = mysqli_fetch_array($results, MYSQLI_ASSOC);
        //проверка заполнения формы 
        foreach ($required as $key) {
            if (empty($_POST[$key])) {  
                $errors[$key] = 'Это поле надо заполнить';
            }
        else {
            $password = password_hash($sign_up['password'], PASSWORD_DEFAULT);
        }
    }
        //проверка формата email 
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'Неправильный формат email';
        }
         //проверка формата email на повторяемость
            if ($data['email'] ==  $e_mail && !empty($data['email']) ){
              $errors['email'] = 'Данный email уже используется другим пользователем';
            }

        } 
        if (count($errors)){
            $sql = "SELECT name_category from categories";

            if ($res = mysqli_query($con, $sql)) {
                $rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
            } else {
                $error = mysqli_connect_error();
                die('Unknown error');
            }
            $page_content = include_template('sign-up.php', [
                'sign_up' => $sign_up,
                'errors' => $errors,
                'dict' => $dict,
                'rows' => $rows,
            ]);
            print($page_content);
} else {
    $sql = "INSERT INTO users (regist_date, email, name, password, contact) VALUES (NOW(),?,?,?,?)";
    $stmt = db_get_prepare_stmt($con, $sql, [$e_mail, $sign_up['name'], $password, $sign_up['contact']]);
    $res = mysqli_stmt_execute($stmt);

    if ($res) {
        header("Location: index.php");
    } else {
        $error = mysqli_connect_error();
        die('Unknown error');
    }
}
}

