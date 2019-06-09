<?php
include_once 'functions.php'; // подключаем файл функций
// переменные
$title = 'Главная страница';
//$value = 'tomorrow midnight';
session_start();
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

mysqli_query($con, 'CREATE FULLTEXT INDEX lot_search ON lots (lot_name, description)');

$search = $_GET['search'] ?? '';

//Получаем текущую страницу. Определяем число лотов на странице
$cur_page = $_GET['page'] ?? 1;
$page_items = 9;

//Считаем смещение
$offset = ($cur_page - 1) * $page_items;

if ($search or $cur_page) {
  $sql = "SELECT l.id, lot_name, picture, first_price, name_category, date_end from lots l
    JOIN categories c ON l.category_id = c.id
    WHERE MATCH(lot_name, description) AGAINST(?)
    ORDER BY date_end DESC LIMIT $page_items OFFSET $offset";


    $stmt = db_get_prepare_stmt($con, $sql, [$search]);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
    $goods = mysqli_fetch_all($result, MYSQLI_ASSOC);

    //Узнаем общее число лотов. Считаем кол-во страниц
    $result = mysqli_query($con, "SELECT COUNT(*) as cnt FROM lots WHERE MATCH(lot_name, description) AGAINST('$search')");
    $items_count = mysqli_fetch_assoc($result)['cnt'];
    $pages_count = ceil($items_count / $page_items);
    
    //Заполняем массив номерами всех страниц
    $pages = range(1, $pages_count);
    //Работа кнопок назад и вперед
    $next_button = $cur_page + 1;
    $back_button = $cur_page - 1;

    $page_content = include_template('search.php', [
      'rows' => $rows,
      'goods' => $goods,
      'pages' => $pages,
      'search' => $search,
      'pages_count' => $pages_count,
      'next_button' => $next_button,
      'back_button' => $back_button
    ]);
    
    // Подключаем - templates/layout.php
    
    $layout_content = include_template('layout.php', [
      'page_content' => $page_content,
      'rows' => $rows,
      'title' => $title,
    ]);
    print($layout_content);

}

else {
  $sql = "SELECT l.id, lot_name, picture, first_price, name_category, date_end from lots l
  JOIN categories c ON l.category_id = c.id";
if ($res = mysqli_query($con, $sql)) {
$goods = mysqli_fetch_all($res, MYSQLI_ASSOC);
} else {
die('Unknown error');
}

// Подключаем - templates/index.php

$page_content = include_template('search.php', [
'rows' => $rows,
'pages' => $pages,
]);

// Подключаем - templates/layout.php

$layout_content = include_template('layout.php', [
'page_content' => $page_content,
'rows' => $rows,
'title' => $title,
]);
print($layout_content);
}
?>