<?php
session_start();
if(isset($_SESSION['pizzas'])){
    $_SESSION['pizzas'] = array();
    echo "Корзина очищена!";
}
else{
    echo "Ошибка!";
}