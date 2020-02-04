<?php
if(isset($_POST)){
    $name = $_POST['firstname'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $comment = $_POST['comment'];
    $cardname = $_POST['cardname'];
    $cardnumber = $_POST['cardnumber'];
    $expmonth = $_POST['expmonth'];
    $expyear = $_POST['expyear'];
    $cvv = $_POST['cvv'];
    $mysqli = new mysqli('localhost', 'jlysmlhb_user', 'ertHi98..DE1', 'jlysmlhb_db');
    $mysqli->set_charset("utf8mb4");
    if(mysqli_connect_errno()){
        echo "FUCK";
        exit;
    }
    $mysqli->query("INSERT INTO `aorders`(`name`, `phone`, `address`, `city`, `comment`, `cardname`, `cardnumber`, `expmonth`, `expyear`, `cvv`, `order_time`, `status`) 
    VALUES ('$name', '$phone', '$address', '$city', '$comment', '$cardname', '$cardnumber', '$expmonth', '$expyear', '$cvv', NOW(), 'waiting')");
    $id = $mysqli->insert_id;
    echo 'success';
}
else echo "error";