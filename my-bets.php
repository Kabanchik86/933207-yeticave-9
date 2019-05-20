<?php
include_once 'functions.php'; // подключаем файл функций
// переменные
$title = 'Главная страница';
$value = 'tomorrow midnight';
session_start();
// запросы в БД
$con = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($con, "utf8");

$sql = "SELECT name_category, symbol_code from categories";

if ($res = mysqli_query($con, $sql)) {
    $rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
} else {
    $error = mysqli_connect_error();
    die('Unknown error');
}


    // Подключаем - templates/index.php

    $page_content = include_template('my-bets.php', [


    ]);

    // Подключаем - templates/layout.php

    $layout_content = include_template('layout.php', [
        'page_content' => $page_content,
        'rows' => $rows,
        'title' => $title,

    ]);
    print($layout_content);

