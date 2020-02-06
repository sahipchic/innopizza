<?php
session_start();
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

    $arr = $_SESSION['pizzas'];
    $seen_ids = array();
    $cnt_items = array();
    foreach($arr as $i){
        if(!in_array($i, $seen_ids)){
            $seen_ids[] = $i;
            $cnt_items[$i] = 1;
        }
        else{
            $cnt_items[$i]++;
        }
    }
    $out = "";
    foreach($seen_ids as $id){
        $item = mysqli_fetch_row($mysqli->query("select name from apizzas where pid=$id"))[0];
        $out .= $item . " x" . $cnt_items[$id] . "
";
    }

    $mysqli->query("INSERT INTO `aorders`(`name`, `phone`, `address`, `city`, `comment`, `items_list`, `cardname`, `cardnumber`, `expmonth`, `expyear`, `cvv`, `order_time`, `status`) 
    VALUES ('$name', '$phone', '$address', '$city', '$comment', '$out','$cardname', '$cardnumber', '$expmonth', '$expyear', '$cvv', NOW(), 'waiting')");

    $id = $mysqli->insert_id;
    if($id > 0){
        $_SESSION['pizzas'] = array();
        echo "success";
    }
    else{
        echo "error";
    }
}
else {
    throw new RuntimeException("Only for POST method access!");
}