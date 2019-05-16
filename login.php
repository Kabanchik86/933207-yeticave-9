<?php
include_once 'functions.php';
// соединение с БД
$con = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($con, "utf8");
session_start();

if (empty($_POST)) {
    // запрос в БД
    $sql = "SELECT name_category from categories";

    if ($res = mysqli_query($con, $sql)) {
        $rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
    } else {
        $error = mysqli_connect_error();
        die('Unknown error');
    }

    $page_content = include_template('login.php', [
        'rows' => $rows,
    ]);

    print($page_content);
} else {

    // валидация формы
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $form = $_POST;
        $required = ['email', 'password'];
        $dict = ['email' => 'E-mail', 'password' => 'Пароль'];
        $errors = [];
        //проверка заполнения формы 
        foreach ($required as $key) {
            if (empty($_POST[$key])) {
                $errors[$key] = 'Это поле надо заполнить';
            }
        }
        $email = mysqli_real_escape_string($con, $form['email']);
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $res = mysqli_query($con, $sql);
        $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;
        if (!count($errors) and $user) {
            if (password_verify($form['password'], $user['password'])) {
                $_SESSION['user'] = $user;
            } else {
                $errors['password'] = 'Неверный пароль';
            }
        } else {
            $errors['email'] = 'Такой пользователь не найден';
        }

        if (count($errors)) {
            $sql = "SELECT name_category from categories";

            if ($res = mysqli_query($con, $sql)) {
                $rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
            } else {
                $error = mysqli_connect_error();
                die('Unknown error');
            }
            $page_content = include_template('login.php', [
                'form' => $form,
                'errors' => $errors,
                'dict' => $dict,
                'rows' => $rows,
            ]);
            print($page_content);
        } else {

            header("Location: index.php");
            exit();
        }
    }
}
