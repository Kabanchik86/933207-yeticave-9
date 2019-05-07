<?php
include_once 'functions.php'; // подключаем файл функций
// переменные
$is_auth = rand(0, 1);
$user_name = 'Anton';
$title = 'Главная страница';
$value = 'tomorrow midnight';

// запросы в БД
$con = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($con, "utf8");

$sql = "SELECT name_category from categories";

if ($res = mysqli_query($con, $sql)) {
    $rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
} else {
    $error = mysqli_connect_error();
    die('Unknown error');
}

$sql = "SELECT l.id, lot_name, picture, first_price, name_category from lots l
        JOIN categories c ON l.category_id = c.id";
if ($res = mysqli_query($con, $sql)) {
    $goods = mysqli_fetch_all($res, MYSQLI_ASSOC);
} else {
    die('Unknown error');
}

// Подключаем - templates/index.php

$page_content = include_template('index.php', [
    'rows' => $rows,
    'goods' => $goods,
    'value' => $value,

]);

// Подключаем - templates/layout.php

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'rows' => $rows,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'title' => $title,

]);
print($layout_content);
