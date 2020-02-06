<?php
$mysqli = new mysqli('remotemysql.com', 'wBMpn2zR3V', 'zxUBDGbtpG', 'wBMpn2zR3V');
$mysqli->set_charset("utf8mb4");
if(mysqli_connect_errno()){
    echo mysqli_connect_error();
}