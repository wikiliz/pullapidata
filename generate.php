<?php
session_start();

require(dirname(__FILE__).'/models/RetrieveData.php');
if(isset($_POST["gen"])){
    $val= new RetrieveData(true);

    echo json_encode(calculate($val->tmpArray));
    exit();
}

function calculate($data){
    $tmp=array();

    $yesterday=date('Y-m-d',strtotime("-1 days"));
    $lastMon=date('Y-m-d',strtotime("-31 days"));

    $tmp[0]["price"]=$data["USD"]["bpi"]["$yesterday"];
    $tmp[0]["change"]=($data["USD"]["bpi"][$yesterday]/$data["USD"]["bpi"][$lastMon])-1;
    $tmp[1]["price"]=$data["EUR"]["bpi"][$yesterday];
    $tmp[1]["change"]=($data["EUR"]["bpi"][$yesterday]/$data["EUR"]["bpi"][$lastMon])-1;
    $tmp[2]["price"]=$data["GBP"]["bpi"][$yesterday];
    $tmp[2]["change"]=($data["GBP"]["bpi"][$yesterday]/$data["GBP"]["bpi"][$lastMon])-1;

    return $tmp;

}