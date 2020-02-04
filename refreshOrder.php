<?php
session_start();
if(isset($_SESSION['pizzas'])){

    require_once 'bd.php';

    $out = "";
    $sum_cost = 0;
    $pids = $_SESSION['pizzas'];
    $pids_map = array();
    foreach ($pids as $i) {
        $pids_map[$i] = 0;
    }
    foreach ($pids as $pid) {
        $pids_map[$pid]++;
    }
    foreach ($pids_map as $pid=>$cnt) {

        $row = mysqli_fetch_row($mysqli->query("select * from apizzas where pid='$pid' limit 1"));
        $name = $row[2];
        $cost = $row[4];
        $sum_cost += $cost * $cnt;
        $out .= "<p class=\"dropdown-item\">$name &nbsp&nbsp<span class=\"badge badge-dark\"> $cnt</span></p>";
    }
    $out .= "<div class=\"dropdown-divider\"></div>";
    $out .= "<p class=\"dropdown-item\">Итог: $sum_cost руб</p>";
    $out .= "<a class=\"dropdown-item\" onclick=\"clearCart(); location.reload();\">Очистить корзину</a>";
    echo $out;
}
else{
    echo "SESSION NOT SET";
}