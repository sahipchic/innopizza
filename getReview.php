<?php
if(isset($_POST)){
    $name = $_POST['name'];
    $city = $_POST['city'];
    $message = $_POST['message'];
    $mysqli = new mysqli('remotemysql.com', 'wBMpn2zR3V', 'zxUBDGbtpG', 'wBMpn2zR3V');
    $mysqli->set_charset("utf8mb4");
    if(mysqli_connect_errno()){
        echo "FUCK";
        exit;
    }
    //echo $name . " " . $city . " " . $message . " " .  " waiting";
    $mysqli->query("INSERT INTO `areviews`(`name`, `city`, `review`, `rtime`, `status`) VALUES ('$name', '$city', '$message', NOW(), 'waiting')");
    $id = $mysqli->insert_id;
    echo $id;
}
else echo "error";