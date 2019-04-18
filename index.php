<?php
$is_auth = rand(0, 1);
$user_name = 'Anton'; // укажите здесь ваше имя
$categories = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];
$title ='Главная страница';
$goods = [
    [
        'name' => '2014 Rossignol District Snowboard',
        'category' => 'Доски и лыжи',
        'price' => 10999,
        'picture' => 'img/lot-1.jpg'
    ],
    [
        'name' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => 'Доски и лыжи',
        'price' => 159999,
        'picture' => 'img/lot-2.jpg'
    ],
    [
        'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => 'Крепления',
        'price' => 8000,
        'picture' => 'img/lot-3.jpg'
    ],
    [
        'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => 'Ботинки',
        'price' => 10999,
        'picture' => 'img/lot-4.jpg'
    ],
    [
        'name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => 'Одежда',
        'price' => 7500,
        'picture' => 'img/lot-5.jpg'
    ],
    [
        'name' => 'Маска Oakley Canopy',
        'category' => 'Разное',
        'price' => 5400,
        'picture' => 'img/lot-6.jpg'
    ]
];

function sum_of_goods($price) {
        $output = 0;
        if ($price > 1000) {
            $output = ceil($price);
            $output = number_format($price, 0, ',', ' ');
        }
        else {
            $output = ceil($price);
        }
      return $output;
}

function include_template($name, array $data = []) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

$page_content = include_template('index.php',['categories'=>$categories, 'goods'=> $goods]);
$layout_content = include_template('layout.php',[
    'page_content'=> $page_content,
    'categories'=>$categories,
    'is_auth'=>$is_auth,
    'user_name'=>$user_name,
    'title'=>$title
    
]);
print($layout_content);
?>