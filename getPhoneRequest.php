<?php
if(isset($_POST)){
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $mysqli = new mysqli('localhost', 'jlysmlhb_user', 'ertHi98..DE1', 'jlysmlhb_db');
    $mysqli->set_charset("utf8mb4");
    if(mysqli_connect_errno()){
        echo "FUCK";
        exit;
    }
    $mysqli->query("INSERT INTO `arequests`(`name`, `phone`, `rtime`, `status`) VALUES ('$name', '$phone', NOW(), 'waiting')");
    $id = $mysqli->insert_id;
    echo "Ваш запрос успешно отправлен! Ожидайте звонка оператора.";
}
else echo "error";