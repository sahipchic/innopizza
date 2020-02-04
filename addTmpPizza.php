<?php
session_start();
if(isset($_SESSION['pizzas'])){
    $data = json_decode(file_get_contents('php://input'), true);
    if(isset($data['pizzaId'])){
        array_push($_SESSION['pizzas'], $data['pizzaId']);
    }
    
    echo 'success';
}
else{
    echo 'error';
}