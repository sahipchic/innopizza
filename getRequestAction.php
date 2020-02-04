<?php
    $data = json_decode(file_get_contents('php://input'), true);
    if(isset($data['request_id']) && isset($data['action'])){
        $id = $data['request_id'];
        $mysqli = new mysqli('localhost', 'jlysmlhb_user', 'ertHi98..DE1', 'jlysmlhb_db');
        $mysqli->set_charset("utf8mb4");
        if($data['action'] == 'delete'){
            $mysqli->query("update arequests set status='closed' where _id='$id'");
        }
        echo "success";
    }
    else echo "error";
