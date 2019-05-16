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

// Подключаем - templates/lot.php
$page_content = include_template('lot.php', [
    'param' => $param,
    'value' => $value,
    'rows' => $rows,
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
