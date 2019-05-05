<?php
$con = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($con, "utf8");

$sql = "SELECT name_category from categories";

$res = mysqli_query($con, $sql); 
$rows = mysqli_fetch_all($res, MYSQLI_ASSOC);

$sql = "SELECT lot_name, picture, first_price, name_category from lots l
        JOIN categories c ON l.category_id = c.id";

$res = mysqli_query($con, $sql); 
$goods = mysqli_fetch_all($res, MYSQLI_ASSOC);

$is_auth = rand(0, 1);
$user_name = 'Anton'; // укажите здесь ваше имя
//$categories = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];
$title = 'Главная страница';
/*$goods = [
[
'name' => '2014 Rossignol District Snowboard',
'category' => 'Доски и лыжи',
'price' => 10999,
'picture' => 'img/lot-1.jpg',
],
[
'name' => 'DC Ply Mens 2016/2017 Snowboard',
'category' => 'Доски и лыжи',
'price' => 159999,
'picture' => 'img/lot-2.jpg',
],
[
'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
'category' => 'Крепления',
'price' => 8000,
'picture' => 'img/lot-3.jpg',
],
[
'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
'category' => 'Ботинки',
'price' => 10999,
'picture' => 'img/lot-4.jpg',
],
[
'name' => 'Куртка для сноуборда DC Mutiny Charocal',
'category' => 'Одежда',
'price' => 7500,
'picture' => 'img/lot-5.jpg',
],
[
'name' => 'Маска Oakley Canopy',
'category' => 'Разное',
'price' => 5400,
'picture' => 'img/lot-6.jpg',
],
];*/

$value = 'tomorrow midnight';

include_once 'functions.php';

$page_content = include_template('index.php', [
    'rows' => $rows,
    'goods' => $goods,
    'value' => $value,

]);
$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'rows' => $rows,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'title' => $title,

]);
print($layout_content);
