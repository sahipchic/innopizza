<?php
if (isset($_POST)) {
    if($_POST['name'] != '' && $_POST['city'] != '' && $_POST['message'] != '') {
        $name = $_POST['name'];
        $city = $_POST['city'];
        $message = $_POST['message'];

        require_once 'bd.php';

        $mysqli->query("INSERT INTO `areviews`(`name`, `city`, `review`, `rtime`, `status`) VALUES ('$name', '$city', '$message', NOW(), 'waiting')");
        $id = $mysqli->insert_id;
        echo 'Your review was successfully added for moderation!';
    }
    else{
        echo 'All fields are required!';
    }
}
else {
    throw new RuntimeException("Only for POST method access!");
}