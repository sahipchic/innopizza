<?php
    $data = json_decode(file_get_contents('php://input'), true);
    if(isset($data['review_id']) && isset($data['action'])){
        $id = $data['review_id'];
        $mysqli = new mysqli('remotemysql.com', 'wBMpn2zR3V', 'zxUBDGbtpG', 'wBMpn2zR3V');
        $mysqli->set_charset("utf8mb4");
        if($data['action'] == 'accept'){
            $mysqli->query("update areviews set status='active' where _id='$id'");     
        }   
        else if($data['action'] == 'reject'){
            $mysqli->query("update areviews set status='rejected' where _id='$id'");
        }
        else if($data['action'] == 'delete'){
            $mysqli->query("update areviews set status='deleted' where _id='$id'");
        }
        echo "success";
    }
    else echo "error";
