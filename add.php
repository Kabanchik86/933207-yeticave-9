
<?php
include_once 'functions.php'; // подключаем файл функций
$title = 'Главная страница';
// соединение с БД
$con = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($con, "utf8");
session_start();
// создание БД


if (empty($_POST)) {
    // запрос в БД
    $sql = "SELECT name_category from categories";

    if ($res = mysqli_query($con, $sql)) {
        $rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
    } else {
        $error = mysqli_connect_error();
        die('Unknown error');
    }

    $page_content = include_template('add-lot.php', [
        'rows' => $rows,
    ]);

    $layout_content = include_template('layout.php', [
        'page_content' => $page_content,
        'rows' => $rows,
        'title' => $title,

    ]);
    print($layout_content);

} else {

    // валидация формы
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $lot = $_POST;
        $required = ['lot_name', 'description', 'first_price', 'price_step', 'name_category', 'date_end'];
        $dict = ['lot_name' => 'Название лота', 'name_category' => 'Категория', 'date_end' => 'Дата окончания торгов', 'picture' => 'Изображение', 'description' => 'Описание', 'first_price' => 'Начальная цена', 'price_step' => 'Шаг ставки'];
        $errors = [];
        foreach ($required as $key) {
            if (empty($_POST[$key])) {  //проверка заполнения формы 
                $errors[$key] = 'Это поле надо заполнить';
            }
        }
        //проверка формата даты 
        if (!is_date_valid($_POST['date_end'])) {
            $errors['date_end'] = 'Не правильный формат даты';
        }
        //проверка значения числа
        if (!(int)$_POST['first_price'] or (int)$_POST['first_price'] <= 0) {
            $errors['first_price'] = 'Введите числовое значение или больше нуля';
        }
        //проверка значения числа
        if (!(int)$_POST['price_step'] or (int)$_POST['price_step'] <= 0) {
            $errors['price_step'] = 'Введите числовое значение или больше нуля';
        }
        //проверка выбранной категории
        if ($_POST['name_category'] == 'Выберите категорию') {
            $errors['name_category'] = 'Выберите категорию';
        }
        //проверка даты окончания торгов
        if ($_POST['date_end'] <= date("Y-m-d")) {
            $errors['date_end'] = 'Указанная дата должна быть больше настоящей хотя бы на один день';
        }

        //проверка файла на его формат и наличие 
        if (isset($_FILES['picture']['name']) && !empty($_FILES['picture']['name'])) {
            $tmp_name = $_FILES['picture']['tmp_name'];
            $path = $_FILES['picture']['name'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_type = finfo_file($finfo, $tmp_name);
            if ($file_type !== "image/jpeg" and $file_type !== "image/png") {
                $errors['picture'] = 'Загрузите картинку в формате JPEG';
            } else {
                move_uploaded_file($tmp_name, 'uploads/' . $path);
                $lot['path'] = $path;
            }
        } else {
            $errors['picture'] = 'Вы не загрузили файл';
        }

        //вывод ошибок в форме если они имеются 
        if (count($errors)) {

            $sql = "SELECT name_category from categories";

            if ($res = mysqli_query($con, $sql)) {
                $rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
            } else {
                $error = mysqli_connect_error();
                die('Unknown error');
            }
            $page_content = include_template('add-lot.php', [
                'lot' => $lot,
                'errors' => $errors,
                'dict' => $dict,
                'rows' => $rows,
            ]);
            $layout_content = include_template('layout.php', [
                'page_content' => $page_content,
                'rows' => $rows,
                'title' => $title,
        
            ]);
            print($layout_content);

            //условие для добавления нового лота       
        } else {

            $name_category = $_POST['name_category'];
            $picture = 'uploads/' . $path;
            $sql = "INSERT INTO lots (creat_date, user_id, lot_name, description, picture, first_price, price_step, date_end ) VALUES (NOW(),1,?,?,?,?,?,?)";
            $stmt = db_get_prepare_stmt($con, $sql, [$lot['lot_name'], $lot['description'], $picture, $lot['first_price'], $lot['price_step'], $lot['date_end']]);
            $res = mysqli_stmt_execute($stmt);

            if ($res) {
                $lot_id = mysqli_insert_id($con);
                $sql = "UPDATE lots 
                    SET category_id = (SELECT id FROM categories WHERE name_category = '$name_category')
                    WHERE category_id IS NULL";
                $res = mysqli_query($con, $sql);
                $param = mysqli_fetch_all($res, MYSQLI_ASSOC);
                header("Location: lot.php?id=" . $lot_id);
            } else {
                $error = mysqli_connect_error();
                die('Unknown error');
            }
        }
    }
}

?>