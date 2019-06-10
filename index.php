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

    //Получаем текущую страницу. Определяем число лотов на странице
    mysqli_query($con, 'CREATE FULLTEXT INDEX search ON categories (name_category)');
    $search = $_GET['search'] ?? '';
    $cur_page = $_GET['page'] ?? 1;
    $page_items = 6;

    //Считаем смещение
    $offset = ($cur_page - 1) * $page_items;

    if ($search) {
        $sql = "SELECT l.id, lot_name, picture, first_price, name_category, date_end from lots l
            JOIN categories c ON l.category_id = c.id
            WHERE MATCH(name_category) AGAINST(?)
            ORDER BY l.id DESC LIMIT $page_items OFFSET $offset";

        $stmt = db_get_prepare_stmt($con, $sql, [$search]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $goods = mysqli_fetch_all($result, MYSQLI_ASSOC);

        //Узнаем общее число лотов. Считаем кол-во страниц
        $result = mysqli_query($con, "SELECT COUNT(*) as cnt FROM lots l
        JOIN categories c ON l.category_id = c.id
        WHERE MATCH(name_category) AGAINST('$search')");
        $items_count = mysqli_fetch_assoc($result)['cnt'];
        $pages_count = ceil($items_count / $page_items);

        //Заполняем массив номерами всех страниц
        $pages = range(1, $pages_count);

        // Подключаем - templates/index.php

        $page_content = include_template('index.php', [
            'rows' => $rows,
            'goods' => $goods,
            'pages' => $pages,
            'pages_count' => $pages_count,
            'search' => $search
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

        $sql = "SELECT l.id, lot_name, picture, first_price, name_category, date_end from lots l
            JOIN categories c ON l.category_id = c.id
            ORDER BY l.id DESC LIMIT $page_items OFFSET $offset";

        if ($res = mysqli_query($con, $sql)) {
            $goods = mysqli_fetch_all($res, MYSQLI_ASSOC);
        } else {
            die('Unknown error');
        }

        //Узнаем общее число лотов. Считаем кол-во страниц
        $result = mysqli_query($con, "SELECT COUNT(*) as cnt FROM lots");
        $items_count = mysqli_fetch_assoc($result)['cnt'];
        $pages_count = ceil($items_count / $page_items);

        //Заполняем массив номерами всех страниц
        $pages = range(1, $pages_count);

        // Подключаем - templates/index.php

        $page_content = include_template('index.php', [
            'rows' => $rows,
            'goods' => $goods,
            'pages' => $pages,
            'pages_count' => $pages_count
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
    }
} else {

    $sql = "SELECT name_category, symbol_code from categories";

    if ($res = mysqli_query($con, $sql)) {
        $rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
    } else {
        $error = mysqli_connect_error();
        die('Unknown error');
    }

    //Получаем текущую страницу. Определяем число лотов на странице
    mysqli_query($con, 'CREATE FULLTEXT INDEX search ON categories (name_category)');
    $search = $_GET['search'] ?? '';
    $cur_page = $_GET['page'] ?? 1;
    $page_items = 6;

    //Считаем смещение
    $offset = ($cur_page - 1) * $page_items;


    if ($search) {
        $sql = "SELECT l.id, lot_name, picture, first_price, name_category, date_end from lots l
            JOIN categories c ON l.category_id = c.id
            WHERE MATCH(name_category) AGAINST(?)
            ORDER BY l.id DESC LIMIT $page_items OFFSET $offset";

        $stmt = db_get_prepare_stmt($con, $sql, [$search]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $goods = mysqli_fetch_all($result, MYSQLI_ASSOC);

        //Узнаем общее число лотов. Считаем кол-во страниц
        $result = mysqli_query($con, "SELECT COUNT(*) as cnt FROM lots l
        JOIN categories c ON l.category_id = c.id
        WHERE MATCH(name_category) AGAINST('$search')");
        $items_count = mysqli_fetch_assoc($result)['cnt'];
        $pages_count = ceil($items_count / $page_items);

        //Заполняем массив номерами всех страниц
        $pages = range(1, $pages_count);

        // Подключаем - templates/index.php

        $page_content = include_template('index.php', [
            'rows' => $rows,
            'goods' => $goods,
            'pages' => $pages,
            'pages_count' => $pages_count,
            'search' => $search
            //'value' => $value,
        ]);

        // Подключаем - templates/layout.php

        $layout_content = include_template('layout.php', [
            'page_content' => $page_content,
            'rows' => $rows,
            'title' => $title,
        ]);
        print($layout_content);
    } else {

        $sql = "SELECT l.id, lot_name, picture, first_price, name_category, date_end from lots l
            JOIN categories c ON l.category_id = c.id
            ORDER BY l.id DESC LIMIT $page_items OFFSET $offset";

        if ($res = mysqli_query($con, $sql)) {
            $goods = mysqli_fetch_all($res, MYSQLI_ASSOC);
        } else {
            die('Unknown error');
        }

        //Узнаем общее число лотов. Считаем кол-во страниц
        $result = mysqli_query($con, "SELECT COUNT(*) as cnt FROM lots");
        $items_count = mysqli_fetch_assoc($result)['cnt'];
        $pages_count = ceil($items_count / $page_items);

        //Заполняем массив номерами всех страниц
        $pages = range(1, $pages_count);

        // Подключаем - templates/index.php

        $page_content = include_template('index.php', [
            'rows' => $rows,
            'goods' => $goods,
            'pages' => $pages,
            'pages_count' => $pages_count
            //'value' => $value,
        ]);

        // Подключаем - templates/layout.php

        $layout_content = include_template('layout.php', [
            'page_content' => $page_content,
            'rows' => $rows,
            'title' => $title,
        ]);
        print($layout_content);
    }
}
