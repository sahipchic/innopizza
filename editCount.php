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
                $newIds = array();
                $flag = false;
                foreach($_SESSION['pizzas'] as $pid){
                    if($pid === $data['pizzaId'] && $flag === false){
                        $flag = true;
                        continue;
                    }
                    else{
                        $newIds[] = $pid;
                    }
                }
                $_SESSION['pizzas'] = $newIds;

                echo --$cnt;
                exit();
            }
        }
    }

    echo 'success';
}
else{
    throw new RuntimeException("No data in session!");
}