<?php
include_once 'functions.php'; // подключаем файл функций
// переменные
$title = 'Главная страница';
//$value = 'tomorrow midnight';
session_start();
// запросы в БД
$con = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($con, "utf8");

if (isset($_SESSION['user']['id'])) {

    $user_id = $_SESSION['user']['id'];
    $sql = "SELECT name_category, symbol_code from categories";

    if ($res = mysqli_query($con, $sql)) {
        $rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
    } else {
        $error = mysqli_connect_error();
        die('Unknown error');
    }

    $sql = "SELECT l.id, lot_name, picture, first_price, name_category, date_end from lots l
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
        //'value' => $value,
    ]);

    // Подключаем - templates/layout.php

    $layout_content = include_template('layout.php', [
        'page_content' => $page_content,
        'rows' => $rows,
        'title' => $title,
        'user_id' => $user_id
    ]);
    print($layout_content);

} else {

    $sql = "SELECT name_category, symbol_code from categories";

    if ($res = mysqli_query($con, $sql)) {
        $rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
    } else {
        $error = mysqli_connect_error();
        die('Unknown error');
    }

    $sql = "SELECT l.id, lot_name, picture, first_price, name_category, date_end from lots l
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
       // 'value' => $value,

    ]);

    // Подключаем - templates/layout.php

    $layout_content = include_template('layout.php', [
        'page_content' => $page_content,
        'rows' => $rows,
        'title' => $title
    ]);
    print($layout_content);
}
