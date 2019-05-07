<?php
include_once 'functions.php'; // подключаем файл функций
// переменные
$value = 'tomorrow midnight';

// запрос в БД
$con = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($con, "utf8");


if (isset($_GET['id']) and empty(!$_GET['id'])) //проверка существования параметра
{
    $id = $_GET['id'];
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

$sql = "SELECT lot_name, picture, first_price, description, name_category  FROM lots l 
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
]);

print($page_content);
