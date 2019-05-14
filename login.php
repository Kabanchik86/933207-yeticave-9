<?php
include_once 'functions.php';
// соединение с БД
$con = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($con, "utf8");

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
