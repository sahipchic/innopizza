<?php
if(isset($_POST)){
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    require_once 'bd.php';

    $mysqli->query("INSERT INTO `arequests`(`name`, `phone`, `rtime`, `status`) VALUES ('$name', '$phone', NOW(), 'waiting')");
    $id = $mysqli->insert_id;
    if($id > 0){
        echo "Ваш запрос #$id успешно отправлен! Ожидайте звонка оператора.";
    }
    else{
        throw new RuntimeException("Insertion error");
    }
}
else {
    throw new RuntimeException("Only for POST method access!");
}