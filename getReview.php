<?php
if(isset($_POST)){
    $name = $_POST['name'];
    $city = $_POST['city'];
    $message = $_POST['message'];

    require_once 'bd.php';

    $mysqli->query("INSERT INTO `areviews`(`name`, `city`, `review`, `rtime`, `status`) VALUES ('$name', '$city', '$message', NOW(), 'waiting')");
    $id = $mysqli->insert_id;
    echo $id;
}
else echo "error";