<?php
    $data = json_decode(file_get_contents('php://input'), true);
    if(isset($data['request_id']) && isset($data['action'])){
        $id = $data['request_id'];
        $mysqli = new mysqli('remotemysql.com', 'wBMpn2zR3V', 'zxUBDGbtpG', 'wBMpn2zR3V');
        $mysqli->set_charset("utf8mb4");
        if($data['action'] == 'delete'){
            $mysqli->query("update arequests set status='closed' where _id='$id'");
        }
        echo "success";
    }
    else echo "error";
