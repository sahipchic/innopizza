<?php
session_start();
if (!isset($_SESSION['pizzas'])) {
    $_SESSION['pizzas'] = array();
}

require_once 'bd.php';

function getRowById($id) {
    global $mysqli;
    $row = mysqli_fetch_row($mysqli->query("select * from apizzas where pid='$id' limit 1"));
    return $row;
}

function getActiveReviews() {
    global $mysqli;
    $result_set = $mysqli->query("select * from areviews where status='active'");
    return $result_set;
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">


    <title>
        InnoPizza
    </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script>
        function addToCart(pizzaid) {
            //console.log('pizzaId: ' + pizzaId);
            jQuery.ajax({
                url: 'addTmpPizza.php',
                dataType: 'json',
                type: 'post',
                contentType: 'application/json',
                data: JSON.stringify({"pizzaId": pizzaid}),
                success: function (response) {
                    //document.getElementById("form_order").innerHTML = "ОФОРМИТЬ ЗАКАЗ()";

                    alert("Товар добавлен в корзину!");
                },
                error: function (answer) {
                    //document.getElementById("form_order").innerHTML = "ОФОРМИТЬ ЗАКАЗ()";
                    alert(answer.responseText);
                }
            });
        }
    </script>
    <script>
        function sendAjaxForm(form) {
            var url = form.getAttribute("action");
            var formData = $(form).serializeArray();
            $.post(url, formData).done(function (data) {
                alert(data);
            });
        }
        
    </script>

    <script>
        function refreshOrder() {
            jQuery.ajax({
                url: 'refreshOrder.php',
                success: function (response) {
                    document.getElementById("dropdown_menu").innerHTML = response;
                    //alert(response);

                },
                error: function (answer) {
                    //document.getElementById("form_order").innerHTML = "ОФОРМИТЬ ЗАКАЗ()";
                    alert("error: " + answer.responseText);
                }
            });
        }
    </script>

    <script>
        function clearCart() {
            jQuery.ajax({
                url: 'clearCart.php',
                success: function (response) {
                    document.getElementById("dropdown_menu").innerHTML = "";
                    alert(response);
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
<nav class="navbar navbar-expand-lg navbar-expand-md navbar-light bg-light fixed-top">
    <a href="#" class="navbar-brand"><img src="img/logo1.png" alt="logo" style="width: 30%; margin-left: 50px;"
                                          class="img-responsive"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-Menu"
            aria-controls="navbar-Menu" expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div style="padding-right: 100px;" class="collapse navbar-collapse" id="navbar-Menu" align="right">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item mr-3 ">
                <a class="nav-link" href="#menu">МЕНЮ</a>
            </li>
            <li class="nav-item mr-3 ">
                <a class="nav-link" href="#reviews">ОТЗЫВЫ</a>
            </li>
            <li class="nav-item mr-3 ">
                <a id="form_order" class="nav-link" href="placeOrder.php">ОФОРМИТЬ ЗАКАЗ</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" onclick="refreshOrder();" id="navbarDropdown" role="button"
                   data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    КОРЗИНА
                </a>
                <div id="dropdown_menu" class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php
                    $out = "";
                    $pids = $_SESSION['pizzas'];
                    $pids_map = array();
                    foreach ($pids as $i) {
                        $pids_map[$i] = 0;
                    }
                    foreach ($pids as $pid) {
                        $pids_map[$pid]++;
                    }
                    $sum_cost = 0;
                    foreach ($pids_map as $pid => $cnt) {
                        $row = getRowById($pid);
                        $name = $row[2];
                        $cost = $row[4];
                        $sum_cost += $cost * $cnt;
                        $out .= "<p class=\"dropdown-item\">$name &nbsp&nbsp<span class=\"badge badge-dark\"> $cnt </span></p>";
                    }
                    $out .= "<div class=\"dropdown-divider\"></div>";
                    $out .= "<p class=\"dropdown-item\">Итог: $sum_cost руб</p>";
                    echo $out;
                    ?>


                    <a class="dropdown-item" onclick="clearCart();">Очистить корзину</a>
                </div>
            </li>

        </ul>
    </div>
</nav>
<div>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="5000">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img height="800" class="d-block w-100" src="img/pizza.jpg" alt="Первый слайд">
                <div style="margin-bottom: 250px;  opacity: 0.8; background: #000; border-radius: 20px;"
                     class="carousel-caption d-none d-md-block">
                    <h1>Добро пожаловать в InnoPizza!</h1>
                    <h3>
                        Для приготовления наших пицц мы используем только самые свежие ингридиенты и следим за
                        качеством каждой приготовленной пиццы!
                    </h3>
                </div>
            </div>
            <div class="carousel-item">
                <img height="800" class="d-block w-100" src="img/pizza2.jpg" alt="Второй слайд">
                <div align="left"
                     style="margin-right: 200px;margin-left: 200px; margin-bottom: 200px; margin-top: 100px; padding-right: 20px; padding-left: 20px; opacity: 0.8; background: #000; border-radius: 20px;"
                     class="carousel-caption d-none d-md-block">
                    <h3>
                        Оставьте вашу заявку и наш оператор обязательно свяжется с вами в течение нескольких минут
                    </h3>
                    <br><br>
                    <form method="post" action="getPhoneRequest.php">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Имя</label>
                            <div class="col">
                                <input type="text" class="form-control" id="input_name" name="name" placeholder="Имя">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-sm-2 col-form-label">Телефон</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="input_phone" name="phone" placeholder="Телефон">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <div align="center" class="col-sm-10">
                                <button type="reset" class="btn btn-success" onclick="sendAjaxForm(this.form);">Оставить заявку</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>
<section id="menu">
    <div class="container">
        <div align="center">
            <h1 style="margin-top: 40px;">Меню</h1>
        </div>
        <div class="card-group text-center p-5">
            <?php
            $result_set = $mysqli->query("select * from apizzas");
            $out = "";
            $i = 0;
            while ($row = $result_set->fetch_assoc()) {
                $id = $row['pid'];
                $name = $row['name'];
                $desc = $row['description'];
                $cost = $row['cost'];
                $weight = $row['weight'];
                $img_link = $row['img_link'];
                $tmp_out = "";
                if ($i % 3 == 0) {
                    $tmp_out .= "<div class=\"row\">";
                }
                $tmp_out .= "<div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-4\">
                        <div class=\"card m-4\">
                        <img class=\"card-img-top mb-3\" src=\"img/$img_link\" alt=\"Card image\">
                        <div class=\"card-block\">
                          <h4 class=\"card-title\">$name</h4>
                          <p class=\"card-text p-3\">$desc</p>
                        <p>Цена: $cost р</p>
                        <p>Вес: $weight г</p>
                          <button type='button' style=\"margin-bottom: 10px;\" class=\"btn btn-info mb-3\" onclick=\"addToCart('$id');\" >Добавить в корзину</button>
                          
                        </div>
                        </div>
                        </div>";
                if ($i % 3 == 2) {
                    $tmp_out .= "</div>";
                }
                $i++;
                $out .= $tmp_out;
            }
            echo $out;
            ?>


        </div>
    </div>
</section>
<section id="reviews">
    <div class="text-center text-light"
         style="background-image: linear-gradient(to top right, rgb(101, 115, 255), rgb(111, 114, 247), rgb(120, 114, 239), rgb(130, 113, 231), rgb(139, 112, 223), rgb(149, 111, 215), rgb(158, 111, 208), rgb(168, 110, 200), rgb(177, 109, 192), rgb(187, 108, 184), rgb(196, 108, 176), rgb(206, 107, 168));background-color: #f2f2f2;padding: 50px 200px 40px 200px;border: 1px solid lightgrey;border-radius: 3px;">
        <div class="customer-reviews pb-4">
            <h2>Что наши клиенты говорят об InnoPizza?</h2>
        </div>
        <div class="carousel slide" data-ride="carousel" id="review-carousel" data-interval="4000">
            <div class="carousel-inner review-inner" role="listbox">
                <?
                $out = "";
                $result_set = getActiveReviews();
                $i = 0;
                while ($row = $result_set->fetch_assoc()) {
                    $name = $row['name'];
                    $review = $row['review'];
                    $city = $row['city'];
                    if ($i == 0) {
                        $out .= "<div class=\"carousel-item active\">";
                    } else {
                        $out .= "<div class=\"carousel-item\">";
                    }
                    $out .= "<h3>Имя: $name</h3>
                    <p><em>$review</em></p>
                    <p><strong>Город: $city</strong></p>
                            </div>";
                    $i++;

                }
                echo $out;
                ?>

            </div>
            <a class="left carousel-control" href="#review-carousel" role="button" data-slide="prev">
                <span class="icon-prev" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="left carousel-control" href="#review-carousel" role="button" data-slide="next">
                <span class="icon-next" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</section>
<section id="make-review">
    <div style="background-color: #f2f2f2;padding: 50px 20px 15px 120px;border: 1px solid lightgrey;border-radius: 3px;">
        <div class="row text-dark">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 text-center text-dark">
                <h2>Оставьте свой собственный отзыв!</h2><br>
                <p>Наша компания с каждым днем стремится стать все лучше и лучше, и в этом нам нужна ваша поддержка!<br><br>Пожалуйста,
                    если у вас есть какие то советы или предложения по работе нашего сервиса, или вы просто хотите
                    оставить отзыв по поводу качества приготовленной пиццы либо качества обслуживания, просто заполните
                    форму, и мы обязательно прочитаем то, что вы нам отправили!</p><br>
                <h3><font color="#fc0808">Только вы делаете нас лучше ♥♥♥️</font></h3>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <form class="" action="getReview.php" method="post">
                    <div class="form-group">
                        <label for="Form-Control-Name"><h5>Имя</h5></label>
                        <input name="name" type="text" class="form-control" id="Form-Control-Name" placeholder="Илья">
                    </div>
                    <div class="form-group">
                        <label for="Form-Input-City"><h5>Город</h5></label>
                        <input name="city" type="text" class="form-control" id="Form-Input-City" placeholder="Москва">
                    </div>
                    <div class="form-group">
                        <label for="Form-Control-TextArea"><h5>Ваш отзыв</h5></label>
                        <textarea name="message" class="form-control" id="Form-Control-Message" rows="3"
                                  placeholder="Напишите что-нибудь..."></textarea>
                    </div>
                    <input type="button" value="Отправить отзыв" class="btn btn-success "
                           onclick="sendAjaxForm(this.form);">
                </form>
            </div>
        </div>
    </div>
</section>

</body>
</html>
