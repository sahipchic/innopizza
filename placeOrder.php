<?php
session_start();

require_once 'bd.php';

function getRowById($id) {
    global $mysqli;
    $row = mysqli_fetch_row($mysqli->query("select * from apizzas where pid=$id limit 1"));
    return $row;
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/placeOrderStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <title>
        Оформление заказа
    </title>

    <script>
        function sendCustomerInfo(form) {
            var url = form.getAttribute("action");
            var formData = $(form).serializeArray();
            $.post(url, formData).done(function (data) {
                if (data === 'success')
                    alert("Ваш заказ успешно оплачен! Наш курьер свяжется с вами по указанному телефону, когда будет подъезжать. Ожидайте и приятного аппетита!");
            });
        }
    </script>
    <script>
        function clearCart() {
            jQuery.ajax({
                url: 'clearCart.php',
                success: function (response) {
                },
                error: function (answer) {
                    alert("error: " + answer.responseText);
                }
            });
        }
    </script>
</head>
<body>

<div align="center" style="color: white;">
    <h1>Оформление заказа</h1>
</div>
<div style="color: white; padding-left: 100px; padding-right: 100px; padding-top: 10px; padding-bottom: 30px;">
    <p>Для того, чтобы оформить заказ, пожалуйста, заполните все данные ниже и удостоверьтесь, что введенная вами
        информация совпадает с реальной, так как вами данные будут обрабатываться банком, и в противном случае
        транзакция может не пройти.
    </p>
</div>
<div class="row">
    <div class="col-75">
        <div class="container">
            <form action="getCustomerInfo.php" method="post">
                <div class="row">
                    <div class="col-50">
                        <h3>Платежный адрес</h3>
                        <label for="fname"><i class="fa fa-user"></i> Полное имя</label>
                        <input required type="text" id="fname" name="firstname" placeholder="Илья Сахипов">
                        <label for="phone"><i class="fa fa-phone"></i> Телефон</label>
                        <input required type="text" id="phone" name="phone" placeholder="+7 (963) 325 82 07">
                        <label for="adr"><i class="fa fa-address-card-o"></i> Адрес</label>
                        <input required type="text" id="adr" name="address" placeholder="Большой проспект П.С. дом 54, кв. 78">
                        <label for="city"><i class="fa fa-institution"></i> Город</label>
                        <input required type="text" id="city" name="city" placeholder="Санкт-Петербург">
                        <label for="comment"><i class="fa fa-comments-o"></i> Комментарий</label>
                        <input type="text" id="comment" name="comment" placeholder="Ваш комментарий к заказу...">
                    </div>
                    <div class="col-50">
                        <h3>Оплата</h3>
                        <label for="fname">Принимаемые карты</label>
                        <div class="icon-container">
                            <i class="fa fa-cc-visa" style="color:navy;"></i>
                            <i class="fa fa-cc-amex" style="color:blue;"></i>
                            <i class="fa fa-cc-mastercard" style="color:red;"></i>
                            <i class="fa fa-cc-discover" style="color:orange;"></i>
                        </div>
                        <label for="cname">Имя на карте</label>
                        <input required type="text" id="cname" name="cardname" placeholder="ILYA SAKHIPOV">
                        <label for="ccnum">Номер карты</label>
                        <input required type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444">
                        <label for="expmonth">Месяц истечения срока действия</label>
                        <input required type="text" id="expmonth" name="expmonth" placeholder="09">
                        <div class="row">
                            <div class="col-50">
                                <label for="expyear">Год истечения</label>
                                <input required type="text" id="expyear" name="expyear" placeholder="2022">
                            </div>
                            <div class="col-50">
                                <label for="cvv">CVV</label>
                                <input required type="text" id="cvv" name="cvv" placeholder="352">
                            </div>
                        </div>
                    </div>

                </div>

                <input type="reset" value="Продолжить оплату" class="btn"
                       onclick="sendCustomerInfo(this.form); clearCart(); window.location.href = 'https://innopizza1.herokuapp.com/index.php';" <?php

                if (isset($_SESSION['pizzas'])) {
                    if(count($_SESSION['pizzas']) == 0) echo 'disabled';
                } else echo 'disabled';

                ?>>
            </form>
        </div>
    </div>
    <div class="col-25">
        <div class="container">
            <h4>Корзина <span class="price" style="color:black"><i class="fa fa-shopping-cart"></i>
        <b>
          <?
          if (isset($_SESSION['pizzas'])) {
              echo count($_SESSION['pizzas']);
          } else echo 0;
          ?>
        </b></span></h4>
            <?php
            $out = "";
            if (isset($_SESSION['pizzas'])) {
                $pids = $_SESSION['pizzas'];

                $sum_cost = 0;
                foreach ($pids as $pid) {
                    $row = getRowById($pid);
                    $name = $row[2];
                    $cost = $row[4];
                    $sum_cost += $cost;
                    $out .= "<p>$name<span class=\"price\">$cost ₽</span></p>";
                }
                echo $out;
            }
            ?>

            <hr>
            <p>Итог <span class="price" style="color:black"><b>
          <?
          global $sum_cost;
          echo $sum_cost . " ₽";
          ?>
          </b></span></p>
        </div>
    </div>
</div>

</body>
</html>

