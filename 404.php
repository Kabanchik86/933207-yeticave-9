<?php
include_once 'functions.php'; // подключаем файл функций
$title = 'Главная страница';
// соединение с БД
$con = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($con, "utf8");
session_start();

$sql = "SELECT name_category from categories";

if ($res = mysqli_query($con, $sql)) {
    $rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
} else {
    $error = mysqli_connect_error();
    die('Unknown error');
}

$page_content = include_template('404.php', [
    'rows' => $rows,
]);

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'rows' => $rows,
    'title' => $title,

]);
print($layout_content);




















?>