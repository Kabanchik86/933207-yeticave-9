<?php
include_once 'functions.php'; // подключаем файл функций
$title = 'Главная страница';
$value = 'tomorrow midnight';
session_start();
// запрос в БД
$con = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($con, "utf8");
$errors['price_bet'] = '';

//проверка существования параметра lot_id;

if (isset($_GET['id']) and !empty($_GET['id'])) {
    $id = intval($_GET['id']);
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

$sql = "SELECT price_bet, name  FROM bets b 
LEFT JOIN users u ON b.user_id = u.id
WHERE b.lot_id = $id";
if ($res = mysqli_query($con, $sql)) {
    $hist = mysqli_fetch_all($res, MYSQLI_ASSOC);
    if ($hist) {
        $sql = "SELECT lot_name, picture, first_price, description, name_category, price_step, date_end, price_bet FROM lots l 
        JOIN categories c ON l.category_id = c.id
        JOIN bets b ON l.id = b.lot_id
        WHERE l.id = $id and b.price_bet = (SELECT price_bet FROM bets WHERE lot_id = $id ORDER BY bet_date DESC LIMIT 1)";
        if ($res = mysqli_query($con, $sql)) {
            $param = mysqli_fetch_all($res, MYSQLI_ASSOC);
            if (empty($param)) {
                http_response_code(404);
                $page404 = include_template('404.php', []);
                die($page404);
            }
        } else {
            http_response_code(404);
            $page404 = include_template('404.php', []);
            die($page404);
        }
    } else {
        $sql = "SELECT lot_name, picture, first_price, description, name_category, price_step, date_end FROM lots l 
    JOIN categories c ON l.category_id = c.id
    WHERE l.id = $id";
        if ($res = mysqli_query($con, $sql)) {
            $param = mysqli_fetch_all($res, MYSQLI_ASSOC);
            if (empty($param)) {
                http_response_code(404);
                $page404 = include_template('404.php', []);
                die($page404);
            }
        } else {
            http_response_code(404);
            $page404 = include_template('404.php', []);
            die($page404);
        }
    }
    // проверка для введенной ставки

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $required = ['price_bet'];
        $dict = ['price_bet' => 'Ваша ставка'];
        $errors = [];
        $price = $param[0]['price_bet'] + $param[0]['price_step'];

        //проверка заполнения формы 
        if (empty($_POST['price_bet'])) {
            $errors['price_bet'] = 'Это поле надо заполнить';
        }

        //проверка числа 
        if (!(int)($_POST['price_bet']) and !empty($_POST['price_bet'])) {
            $errors['price_bet'] = 'Введите числовое значение';
        }

        if ((int)($_POST['price_bet']) and (int)($_POST['price_bet']) < $price) {
            $errors['price_bet'] = 'Введите значение больше минимальной ставки';
        }

        if (count($errors)) {
            $sql = "SELECT name_category from categories";

            if ($res = mysqli_query($con, $sql)) {
                $rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
            } else {
                $error = mysqli_connect_error();
                die('Unknown error');
            }
            $page_content = include_template('lot.php', [
                'param' => $param,
                'hist' => $hist,
                'value' => $value,
                'rows' => $rows,
                'id' => $id,
                'errors' => $errors
            ]);

            $layout_content = include_template('layout.php', [
                'page_content' => $page_content,
                'rows' => $rows,
                'title' => $title,

            ]);
            print($layout_content);
        } else {
            $praice_bet = $_POST;
            $sql = "INSERT INTO bets (bet_date, price_bet) VALUES (NOW(),?)";
            $stmt = db_get_prepare_stmt($con, $sql, [$praice_bet['price_bet']]);
            $res = mysqli_stmt_execute($stmt);

            if ($res) {
                $user_id = $_SESSION['user']['id'];
                $sql = "UPDATE bets 
                SET user_id = (SELECT id FROM users WHERE id = '$user_id')
                WHERE user_id IS NULL";
                $res = mysqli_query($con, $sql);
                $param = mysqli_fetch_all($res, MYSQLI_ASSOC);
                $sql = "UPDATE bets 
                SET lot_id = (SELECT id FROM lots WHERE id = '$id')
                WHERE lot_id IS NULL";
                $res = mysqli_query($con, $sql);
                $param = mysqli_fetch_all($res, MYSQLI_ASSOC);
                header("Location: my-bets.php?id=" . $user_id);
            }
        }
    } else {

        $page_content = include_template('lot.php', [
            'param' => $param,
            'hist' => $hist,
            'value' => $value,
            'rows' => $rows,
            'id' => $id,
            'errors' => $errors
        ]);
        $layout_content = include_template('layout.php', [
            'page_content' => $page_content,
            'rows' => $rows,
            'title' => $title

        ]);
        print($layout_content);
    }
}
