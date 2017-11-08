<?php
declare(strict_types=0);
session_start();

require(dirname(__FILE__).'/models/RetrieveData.php');

function validate(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(empty(trim($_POST['bitcoin']))&&empty(trim($_POST['currency']))){
            $error["error"]="please enter value";
            return $error;
        }
        if(!empty(trim($_POST['bitcoin']))&&!empty(trim($_POST['currency']))){
            $error["error"]="please enter value only one textbox ";
            return $error;
        }
    }
    return "";
}
function calculate($tmp){
    $currenyCode=$_POST["selcurrency"];
    $rate=$tmp["bpi"][$currenyCode]["rate"];
    $json["updated"]=$tmp["time"]["updated"];
    $rate=floatval(str_replace(",","",$rate));
    $rate=(float)$rate;
    $json["rate"]=$rate;
    if(!empty($_POST["currency"])){
        try {
            if(is_numeric($_POST["currency"])) {
                $json["bitcoin"] =$_POST["currency"]/$rate;
                $json["currency"]=$_POST["currency"];
            }
        } catch (DivisionByZeroError $e) {
            return $e->getMessage();
        }
    }
    elseif(!empty($_POST["bitcoin"])) {
        $json["currency"] =$rate * $_POST["bitcoin"];
        $json["bitcoin"] = $_POST["bitcoin"];
    }
    return $json;
}
$val=validate();
if(!empty($val)){
    echo json_encode($val);
    exit();
}
else{
    $val= new RetrieveData;
    $json=calculate($val->tmpArray);
    echo json_encode($json);
}






