<?php
$mysqli = new mysqli('remotemysql.com', 'wBMpn2zR3V', 'zxUBDGbtpG', 'wBMpn2zR3V');
$mysqli->set_charset("utf8mb4");
if(mysqli_connect_errno()){
    echo "error";
}
$mysqli->query("insert into admin_info (login, password) values ('admin', 'admin')");
$id = $mysqli->insert_id;
echo $id;
