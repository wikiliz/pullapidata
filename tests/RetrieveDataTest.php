<?php

use PHPUnit\Framework\TestCase;
class RetrieveDataTest extends TestCase
{
     private $API="https://api.coindesk.com/v1/bpi/currentprice.json";
        public function setUp(){

        }
        public function testAPIUrl_curl(){
            $data=get_headers($this->API);
            $this->assertEquals('HTTP/1.1 200 OK', $data[0]);

        }
}
