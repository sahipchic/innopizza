<?php
if(isset($_POST)){
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    require_once 'bd.php';

    $mysqli->query("INSERT INTO `arequests`(`name`, `phone`, `rtime`, `status`) VALUES ('$name', '$phone', NOW(), 'waiting')");
    $id = $mysqli->insert_id;
    echo "Ваш запрос успешно отправлен! Ожидайте звонка оператора.";
}
else echo "error";