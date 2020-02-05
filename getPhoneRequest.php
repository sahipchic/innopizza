<?php
if(isset($_POST)){
    if(isset($_POST['name']) && isset($_POST['phone'])) {
        $name = $_POST['name'];
        $phone = $_POST['phone'];

        require_once 'bd.php';

        $mysqli->query("INSERT INTO `arequests`(`name`, `phone`, `rtime`, `status`) VALUES ('$name', '$phone', NOW(), 'waiting')");
        $id = $mysqli->insert_id;
        if ($id > 0) {
            echo "Your request #$id was successfully sent! Wait for the operator call.";
        } else {
            throw new RuntimeException("Insertion error");
        }
    }
    else{
        echo "All fields are required!";
    }
}
else {
    throw new RuntimeException("Only for POST method access!");
}