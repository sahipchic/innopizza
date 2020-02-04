<?php
    session_start(); 
    $mysqli = new mysqli('localhost', 'jlysmlhb_user', 'ertHi98..DE1', 'jlysmlhb_db');
    $mysqli->set_charset("utf8mb4");
    
    function getRowById($id){
        global $mysqli;
        $row = mysqli_fetch_row($mysqli->query("select * from apizzas where pid=$id limit 1"));
        return $row;
    }
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<title>
    Оформление заказа
</title>
<style>
body {
  font-family: Arial;
  font-size: 17px;
  padding: 8px;
  background-image: linear-gradient(to top right, rgb(101, 115, 255), rgb(111, 114, 247), rgb(120, 114, 239), rgb(130, 113, 231), rgb(139, 112, 223), rgb(149, 111, 215), rgb(158, 111, 208), rgb(168, 110, 200), rgb(177, 109, 192), rgb(187, 108, 184), rgb(196, 108, 176), rgb(206, 107, 168));background-color: #f2f2f2;
}

* {
  box-sizing: border-box;
}

.row {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  margin: 0 -16px;
}

.col-25 {
  -ms-flex: 25%; /* IE10 */
  flex: 25%;
}

.col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
}

.col-75 {
  -ms-flex: 75%; /* IE10 */
  flex: 75%;
}

.col-25,
.col-50,
.col-75 {
  padding: 0 16px;
}

.container {
  background-color: #f2f2f2;
  padding: 5px 20px 15px 20px;
  border: 1px solid lightgrey;
  border-radius: 3px;
}

input[type=text] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}

.btn {
  background-color: #4CAF50;
  color: white;
  padding: 12px;
  margin: 10px 0;
  border: none;
  width: 100%;
  border-radius: 3px;
  cursor: pointer;
  font-size: 17px;
}

.btn:hover {
  background-color: #45a049;
}

a {
  color: #2196F3;
}

hr {
  border: 1px solid lightgrey;
}

span.price {
  float: right;
  color: grey;
}

/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (also change the direction - make the "cart" column go on top) */
@media (max-width: 800px) {
  .row {
    flex-direction: column-reverse;
  }
  .col-25 {
    margin-bottom: 20px;
  }
}
</style>
<script>
        function sendCustomerInfo(form) {
            var url = form.getAttribute("action");
            var formData = $(form).serializeArray();
            $.post(url, formData).done(function (data) {
                //alert(data);
                if(data == 'success')
                    alert("Ваш заказ успешно оплачен! Наш курьер свяжется с вами по указанному телефону, когда будет подъезжать. Ожидайте и приятного аппетита!");
            });
        }
</script>
<script>
    function clearCart(){
            jQuery.ajax({
                url: 'clearCart.php',
                success: function (response) {
                    
                },
                error: function (answer) {
                    //document.getElementById("form_order").innerHTML = "ОФОРМИТЬ ЗАКАЗ()";
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
<p>Для того, чтобы оформить заказ, пожалуйста, заполните все данные ниже и удостоверьтесь, что введенная вами информация совпадает с реальной, так как вами данные будут обрабатываться банком, и в противном случае транзакция может не пройти.</p>
</div>
<div class="row">
  <div class="col-75">
    <div class="container">
      <form action="getCustomerInfo.php" method="post">
      
        <div class="row">
          <div class="col-50">
            <h3>Платежный адрес</h3>
            <label for="fname"><i class="fa fa-user"></i> Полное имя</label>
            <input type="text" id="fname" name="firstname" placeholder="Илья Сахипов">
            <label for="phone"><i class="fa fa-phone"></i> Телефон</label>
            <input type="text" id="phone" name="phone" placeholder="+7 (963( 325 82 07">
            <label for="adr"><i class="fa fa-address-card-o"></i> Адрес</label>
            <input type="text" id="adr" name="address" placeholder="Большой проспект П.С. дом 54, кв. 78">
            <label for="city"><i class="fa fa-institution"></i> Город</label>
            <input type="text" id="city" name="city" placeholder="Санкт-Петербург">
            
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
            <input type="text" id="cname" name="cardname" placeholder="ILYA SAKHIPOV">
            <label for="ccnum">Номер карты</label>
            <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444">
            <label for="expmonth">Месяц истечения срока действия</label>
            <input type="text" id="expmonth" name="expmonth" placeholder="09">
            <div class="row">
              <div class="col-50">
                <label for="expyear">Год истечения</label>
                <input type="text" id="expyear" name="expyear" placeholder="2022">
              </div>
              <div class="col-50">
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv" placeholder="352">
              </div>
            </div>
          </div>
          
        </div>
        
        <input type="button" value="Продолжить оплату" class="btn" onclick="sendCustomerInfo(this.form); clearCart(); window.location.href = 'https://bestproger.ru/innopizza/index.php';">
      </form>
    </div>
  </div>
  <div class="col-25">
    <div class="container">
      <h4>Корзина <span class="price" style="color:black"><i class="fa fa-shopping-cart"></i> 
        <b>
          <?   
            if(isset($_SESSION['pizzas'])){
                echo count($_SESSION['pizzas']);     
            }
            else echo 0;
          ?>
        </b></span></h4>
      <?php
        $out = "";
        if(isset($_SESSION['pizzas'])){
            $pids = $_SESSION['pizzas'];
        
            $sum_cost = 0;
            foreach($pids as $pid){
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

