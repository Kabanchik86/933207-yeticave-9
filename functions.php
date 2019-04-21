<?php

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
