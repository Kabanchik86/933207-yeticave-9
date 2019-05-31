<?php
include_once 'functions.php'; // подключаем файл функций
// переменные
$title = 'Главная страница';
$value = 'tomorrow midnight';
session_start();
// запросы в БД
$con = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($con, "utf8");
$remaining_minutes = 28;

if (isset($_SESSION['user']['id']) and !empty($_SESSION['user']['id'])) //проверка существования параметра
{
    $user_id = intval($_SESSION['user']['id']);
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

$sql = "SELECT lot_id, price_bet from bets
WHERE user_id =  $user_id";

if ($res = mysqli_query($con, $sql)) {
    $lot = mysqli_fetch_all($res, MYSQLI_ASSOC);
} else {
    $error = mysqli_connect_error();
    die('Unknown error');
}

if ($lot){
foreach ($lot as $key => $val) {
    if ($val) {
        $lot_id = $val['lot_id'];
        $price_bet = $val['price_bet'];
        $sql = "SELECT lot_name, picture, name_category, date_end, price_bet, l.id from lots l
    JOIN categories c ON l.category_id = c.id
    JOIN bets b ON l.id = b.lot_id
    WHERE l.id = $lot_id and b.price_bet = $price_bet";
        if ($data = mysqli_query($con, $sql)) {
            $bet_data[] = mysqli_fetch_array($data, MYSQLI_ASSOC);
        } else {
            $error = mysqli_connect_error();
            die('Unknown error');
        }
    }

}
// Подключаем - templates/index.php
$page_content = include_template('my-bets.php', [
    'rows' => $rows,
    'bet_data' => $bet_data,
    'remaining_minutes' => $remaining_minutes,
    'val' => $val,

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
    $page_content = include_template('my-bets.php', [
        'rows' => $rows,
    
    ]);
    
    // Подключаем - templates/layout.php
    $layout_content = include_template('layout.php', [
        'page_content' => $page_content,
        'rows' => $rows,
        'title' => $title,
        'user_id' => $user_id
    
    ]);
    print($layout_content);
}
