<?php
session_start();
function getCountById($id){
    $tmp = $_SESSION['pizzas'];
    $cnt = 0;
    foreach ($tmp as $i){
        if($i == $id) $cnt++;
    }
    return $cnt;
}
if(isset($_SESSION['pizzas'])){
    $data = json_decode(file_get_contents('php://input'), true);
    if(isset($data['pizzaId']) && isset($data['action'])){
        $cnt = getCountById($data['pizzaId']);
        if($data['action'] == 'increase'){
            $_SESSION['pizzas'][] = $data['pizzaId'];
            echo ++$cnt;
            exit();
        }
        else if($data['action'] == 'decrease'){
            if($cnt == 0){
                echo $cnt;
                exit();
            }
            else{

                $arr = array();
                $flag = false;
                foreach($_SESSION['pizzas'] as $ss){
                    if($ss === $data['pizzaId'] && $flag === false){
                        $flag = true;
                        continue;
                    }
                    else{
                        $arr[] = $ss;
                    }
                }
                $_SESSION['pizzas'] = $arr;

                $cnt--;
                echo $cnt;
                exit();
            }
        }
    }

    echo 'success';
}
else{
    echo 'error';
}