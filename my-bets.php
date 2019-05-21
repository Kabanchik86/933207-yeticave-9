<?php
include_once 'functions.php'; // подключаем файл функций
// переменные
$title = 'Главная страница';
$value = 'tomorrow midnight';
session_start();
// запросы в БД
$con = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($con, "utf8");
$user_id = $_SESSION['user']['id'];


if (isset($user_id) and !empty($user_id)) //проверка существования параметра
{
    $id = intval($user_id);
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


$sql = "SELECT lot_name, picture, name_category from lots l
    JOIN categories c ON l.category_id = c.id
    WHERE user_id = $id";

if ($data = mysqli_query($con, $sql)) {
    $datas = mysqli_fetch_all($data, MYSQLI_ASSOC);
} else {
    $error = mysqli_connect_error();
    die('Unknown error');
}


// Подключаем - templates/index.php

$page_content = include_template('my-bets.php', [
    'rows' => $rows,
    'datas' => $datas,

]);

// Подключаем - templates/layout.php

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'rows' => $rows,
    'title' => $title,
    'user_id' => $user_id

]);
print($layout_content);
