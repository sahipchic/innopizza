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

    require_once 'bd.php';

    $mysqli->query("INSERT INTO `aorders`(`name`, `phone`, `address`, `city`, `comment`, `cardname`, `cardnumber`, `expmonth`, `expyear`, `cvv`, `order_time`, `status`) 
    VALUES ('$name', '$phone', '$address', '$city', '$comment', '$cardname', '$cardnumber', '$expmonth', '$expyear', '$cvv', NOW(), 'waiting')");
    $id = $mysqli->insert_id;
    if($id > 0){
        echo "success";
    }
    else{
        echo "error";
        //throw new RuntimeException("Insertion error");
    }
}
else {
    throw new RuntimeException("Only for POST method access!");
}