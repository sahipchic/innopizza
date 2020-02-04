<?php
$data = json_decode(file_get_contents('php://input'), true);
if (isset($data['id']) && isset($data['action'])) {
    $id = $data['id'];

    require_once 'bd.php';

    switch ($data['action']) {
        case 'accept':
            $mysqli->query("update areviews set status='active' where _id='$id'");
            break;
        case 'reject':
            $mysqli->query("update areviews set status='rejected' where _id='$id'");
            break;
        case 'delete':
            $mysqli->query("update areviews set status='deleted' where _id='$id'");
            break;
        default:
            throw new RuntimeException("Unsupported action " . $data['action']);
    }
    echo "success";
}
else {
    echo "error";
}
