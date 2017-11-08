<?php
define("APIURL", "https://api.coindesk.com/v1/bpi/currentprice.json");
define("HISTORICALDATA","https://api.coindesk.com/v1/bpi/historical/close.json");

class RetrieveData {

 public $tmpArray=array();

    function __construct($lastMovement=false) {

        if(!$lastMovement) {
            $this->tmpArray = json_decode($this->executeCall(APIURL), true);
        }else{
            $this->calculateCurrencies();
        }
        
    }

    private function calculateCurrencies(){
        $currencyArr=array("USD","GBP","EUR");
        foreach($currencyArr as $l=>$f){
            $this->tmpArray[$f]= json_decode($this->executeCall(HISTORICALDATA,$f), true);
        }

    }
    private function executeCall($url,$currency=null) {

            if($currency){
                $url.="?currency=".$currency;
            }
            $curlSession = curl_init();

            // Set the URL
            curl_setopt($curlSession, CURLOPT_URL, $url);

            curl_setopt($curlSession, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

            curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, 1);

            $responseData = curl_exec($curlSession);

            if (curl_errno($curlSession)){
                throw new Exception(curl_error($curlSession));
            }
            curl_close($curlSession);

            return $responseData;
        }

  
  } 
   
