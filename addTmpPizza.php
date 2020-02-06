<?php
session_start();
if (isset($_SESSION['pizzas'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['pizzaId'])) {
        $_SESSION['pizzas'][] = $data['pizzaId'];
    }
    echo 'The product was successfully added to the cart';
}
else {
    echo 'error';
}