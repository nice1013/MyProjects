<?php

function api_query($method, array $req = array()) {
        // API settings
        $key = 'c0569023a896553f059fe2ed31939ca6516fa43e'; //e52d313386fe1304ea4870add094e4e851d4cacb 
        $secret = '31a357d0413cd04446d3b88281fdff2f45021b31c45e09d808738ed78ac78d9929b8dc28cad9ccd8'; // your Secret-key
 
        $req['method'] = $method;
        $mt = explode(' ', microtime());
        $req['nonce'] = $mt[1];
       
        // generate the POST data string
        $post_data = http_build_query($req, '', '&');

        $sign = hash_hmac("sha512", $post_data, $secret);
 
        // generate the extra headers
        $headers = array(
                'Sign: '.$sign,
                'Key: '.$key,
        );
 
        // our curl handle (initialize if required)
        static $ch = null;
        if (is_null($ch)) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; Cryptsy API PHP client; '.php_uname('s').'; PHP/'.phpversion().')');
        }
        curl_setopt($ch, CURLOPT_URL, 'https://www.cryptsy.com/api');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
 
        // run the query
        $res = curl_exec($ch);

        if ($res === false) throw new Exception('Could not get reply: '.curl_error($ch));
        $dec = json_decode($res, true);
        if (!$dec) throw new Exception('Invalid data received, please make sure connection is working and requested API exists');
        return $dec;
}





















 
//$result = api_query("getinfo");

//$result = api_query("getmarkets");

//$result = api_query("mytransactions");

//$result = api_query("markettrades", array("marketid" => 120));

//$result = api_query("marketorders", array("marketid" => 26));

//$result = api_query("mytrades", array("marketid" => 26, "limit" => 1000));

//$result = api_query("allmytrades");

//$result = api_query("myorders", array("marketid" => 26));

//$result = api_query("allmyorders");

//$result = api_query("createorder", array("marketid" => 26, "ordertype" => "Sell", "quantity" => 1000, "price" => 0.00031000));

//$result = api_query("cancelorder", array("orderid" => 139567));
 
//$result = api_query("calculatefees", array("ordertype" => 'Buy', 'quantity' => 1000, 'price' => '0.005'));


//echo "<pre>".print_r($result, true)."</pre>";


//How to echo Return Results. GETMARKETS
//echo $result['return'][0]['label'];
//echo max(array_map('count', $result));



//$result = api_query("getinfo");
//$markets = array("marketid" => 132);
//$result = api_query("marketorders",$markets );
//var_dump($result);

//echo "<br />Sell Price:".$result["return"]['sellorders'][0]['sellprice'];

//$result = api_query("orderdata");
$slot = 0;/*
for ($i = 0; $i < 118; $i++)
{

if ($result['return'][$i]['marketid'] == 132)
{ $slot = $i;}
}
echo "<br />".$result['return'][$slot]['marketid'] ."
<br />";
echo "<br />".$result['return'][$slot]['current_volume'] ."
<br />";
var_dump($result);*/
?>
