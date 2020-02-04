<?php
session_start();
if(isset($_SESSION['pizzas'])){
    $data = $_SESSION['pizzas'];
    $out = "";
    foreach($data as $i){
        $out .= $i . " ";
    }
    echo $out;
}
else echo "Пошел нахуй";