
<?php
include_once 'functions.php'; // подключаем файл функций

// соединение с БД
$con = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($con, "utf8");

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

    print($page_content);
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
        if (!(int)$_POST['first_price']) {
            $errors['first_price'] = 'Введите числовое значение';
        }
        //проверка значения числа
        if (!(int)$_POST['price_step']) {
            $errors['price_step'] = 'Введите числовое значение';
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
            print($page_content);

            //условие для добавления нового лота       
        } else {

            $lot_name = $_POST['lot_name'];
            $description = $_POST['description'];
            $name_category = $_POST['name_category'];
            $first_price = $_POST['first_price'];
            $price_step = $_POST['price_step'];
            $date_end = $_POST['date_end'];
            $path = $_FILES['picture']['name'];
            $picture = 'uploads/' . $path;

            $sql = "INSERT INTO lots (creat_date, user_id, lot_name, description, picture, first_price, price_step, date_end ) VALUES (NOW(),1,?,?,?,?,?,?)";

            $stmt = db_get_prepare_stmt($con, $sql, [$lot_name, $description, $picture, $first_price, $price_step, $date_end]);
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