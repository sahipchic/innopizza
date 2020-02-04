<?php
session_start();
if (isset($_GET['exit']) && $_GET['exit'] == 1) {
    unset($_SESSION['login'], $_SESSION['password']);
}
$is_admin = false;
$echo = "
<html>
        <head>
            <title>
                Admin Page
            </title>
            <link href='//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet' id='bootstrap-css'>
            <link href='css/admin.css' rel='stylesheet'>
            <script src='//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>
            <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
        </head>
    <body>
        <div class='wrapper fadeInDown'>
            <div id='formContent'>
        
                <div class='fadeIn first'>
                    <br><h4>Вход в панель управления</h4><br>
                </div>
                <form method='post' action='admin.php'>
                    <input type='text' id='login' class='fadeIn second' name='login' placeholder='login'>
                    <input type='text' id='password' class='fadeIn third' name='password' placeholder='password'>
                    <input type='submit' class='fadeIn fourth' value='Войти'>
                </form>
            </div>
        </div>
    </body>
</html>";

require_once 'bd.php';

function login($login, $password) {
    global $mysqli;
    $loginResult = $mysqli->query("SELECT * FROM admin_info WHERE login='$login' AND password='$password'");

    if (mysqli_num_rows($loginResult) == 1) {
        return true;
    }
    else {
        unset($_SESSION['login'], $_SESSION['password']);
        return false;
    }
}

if (isset($_POST['login']) && isset($_POST['password'])) {
    $_SESSION['login'] = $_POST['login'];
    $_SESSION['password'] = $_POST['password'];
}

if (isset($_SESSION['login']) && isset($_SESSION['password']) && login($_SESSION['login'], $_SESSION['password'])) {
    $is_admin = true;
}
if (!$is_admin) {
    echo $echo;
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
        function sendActionForReviewOrRequest(id, action, url) {
            jQuery.ajax({
                url: url,
                dataType: 'json',
                type: 'post',
                contentType: 'application/json',
                data: JSON.stringify({"id": id, "action": action}),
                success: function (response) {
                    if (response.responseText === "success") {
                        alert("Успешно!");
                        location.reload();
                    }
                    else if (response.responseText === "error") {
                        alert("Ошибка! Перезагрузите страницу и повторите попытку.");
                    }
                    else {
                        alert(response.responseText);
                    }
                },
                error: function (response) {
                    if (response.responseText === "success") {
                        alert("Успешно!");
                        location.reload();
                    }
                    else if (response.responseText === "error") {
                        alert("Ошибка! Перезагрузите страницу и повторите попытку.");
                    }
                    else {
                        alert(response.responseText);
                    }
                }
            });
        }
    </script>
</head>
<body>
    <ul class="nav nav-tabs">
        <li class="nav-item active">
            <a class="nav-link" data-toggle="tab" href="#history">История заказов</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#waiting-reviews">Отзывы в ожидании</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#active-reviews">Активные отзывы</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#phone-requests">Заявки на созвон</a>
        </li>
        <li>
            <div style=" padding-top: 5px; margin-left: 500px; margin-right: 20px;">
                <a href="https://innopizza1.herokuapp.com/admin.php">
                    <button style="height: 30px;padding-top: 4px;" class="btn btn-success">Обновить</button>
                </a>
            </div>
        </li>
        <li>
            <div style="padding-top: 5px; padding-left: 20px;">
                <a href="https://bestproger.ru/innopizza/admin.php?exit=1">
                    <button style="height: 30px; padding-top: 4px;" class="btn btn-danger">Выйти</button>
                </a>
            </div>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="history">
            <div class="container">
                <h2>История заказов</h2>
                <p>Все заказы, отсортированные по дате добавления</p>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Comment</th>
                        <th>Time</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $out = "";
                    global $mysqli;
                    $result_set = $mysqli->query("select * from aorders order by order_time desc");
                    while ($row = $result_set->fetch_assoc()) {
                        $name = $row['name'];
                        $phone = $row['phone'];
                        $address = $row['address'];
                        $city = $row['city'];
                        $comment = $row['comment'];
                        $time = $row['order_time'];
                        $status = $row['status'];
                        $out .= "<tr>
                            <td>$name</td>
                            <td>$phone</td>
                            <td>$address</td>
                            <td>$city</td>
                            <td>$comment</td>
                            <td>$time</td>
                            <td>$status</td>
                        </tr>";
                    }
                    echo $out;
                    ?>

                    </tbody>
                </table>

            </div>
        </div>
        <div class="tab-pane fade" id="waiting-reviews">
            <div class="container">
                <h2>Отзывы в ожидании</h2>
                <p>Список отзывов, отсортированных по дате добавления, которые нужно либо одобрить, либо отклонить</p>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>City</th>
                        <th>Review</th>
                        <th>Time</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $out = "";
                    global $mysqli;
                    $result_set = $mysqli->query("select * from areviews where status='waiting' order by rtime desc");
                    while ($row = $result_set->fetch_assoc()) {
                        $id = $row['_id'];
                        $name = $row['name'];
                        $city = $row['city'];
                        $review = $row['review'];
                        $time = $row['rtime'];
                        $out .= "<tr>
                            <td>$name</td>
                            <td>$city</td>
                            <td>$review</td>
                            <td>$time</td>
                            <td>
                            <div style='display: flex;flex-direction: row;justify-content: flex-start;'>
                            <div><button class=\"btn btn-success\" onclick=\"sendActionForReviewOrRequest('$id', 'accept', 'getReviewAction.php');\">Accept</button></div>
                            <div style='padding-left: 10px;'><button class=\"btn btn-danger\" onclick=\"sendActionForReviewOrRequest('$id', 'reject', 'getReviewAction.php');\">Reject</button></div>
                            </div>
                            </td>
                        </tr>";
                    }
                    echo $out;
                    ?>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="active-reviews">
            <div class="container">
                <h2>Активные отзывы</h2>
                <p>Отзывы, отсортированные по дате добавления, которые показываются на главной странице</p>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>City</th>
                        <th>Review</th>
                        <th>Time</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $out = "";
                    global $mysqli;
                    $result_set = $mysqli->query("select * from areviews where status='active' order by rtime desc");
                    while ($row = $result_set->fetch_assoc()) {
                        $id = $row['_id'];
                        $name = $row['name'];
                        $city = $row['city'];
                        $review = $row['review'];
                        $time = $row['rtime'];
                        $out .= "<tr>
                            <td>$name</td>
                            <td>$city</td>
                            <td>$review</td>
                            <td>$time</td>
                            <td>
                            <button class=\"btn btn-danger\" onclick=\"sendActionForReviewOrRequest('$id', 'delete', 'getReviewAction.php');\">Delete</button>
                            </td>
                        </tr>";
                    }
                    echo $out;
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="phone-requests">
            <div class="container">
                <h2>Заявки в ожидании</h2>
                <p></p>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Time</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $out = "";
                    global $mysqli;
                    $result_set = $mysqli->query("select * from arequests where status='waiting' order by rtime desc");
                    while ($row = $result_set->fetch_assoc()) {
                        $id = $row['_id'];
                        $name = $row['name'];
                        $phone = $row['phone'];
                        $time = $row['rtime'];
                        $out .= "<tr>
                            <td>$name</td>
                            <td>$phone</td>
                            <td>$time</td>
                            <td>
                            <button class=\"btn btn-danger\" onclick=\"sendActionForReviewOrRequest('$id', 'delete', 'getRequestAction.php');\">Delete</button>
                            </td>
                        </tr>";
                    }
                    echo $out;
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>



