<?php
$data = json_decode(file_get_contents('php://input'), true);
if (isset($data['id']) && isset($data['action'])) {
    $id = $data['id'];

    require_once 'bd.php';

    if ($data['action'] == 'delete') {
        $mysqli->query("update arequests set status='closed' where _id='$id'");
        echo 'success';
    }
    else {
        throw new RuntimeException("Unsupported action " . $data['action']);
    }
}
else {
    echo "error";
}
