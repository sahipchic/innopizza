<?php
session_start();
if (isset($_SESSION['pizzas'])) {
    $_SESSION['pizzas'] = array();
    echo "The cart is cleared!";
}
else {
    echo "Error!";
}