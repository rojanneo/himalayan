<?php 

$client = new SoapClient('http://beta.purepharma.com/index.php/api/soap/?wsdl',array('trace' => 1));

$session = $client->login('dreamlogistics', 'dreamlogistics');
$result = $client->call($session, 'catalog_product.list');
var_dump($result);


// $proxy = new SoapClient('http://beta.purepharma.com/index.php/api/v2_soap/?wsdl');

// $sessionId = $proxy->login((object)array('username' => 'rojan', 'apiKey' => 'rojan123'));
// $complexFilter = array(
//     'complex_filter' => array(
//         array(
//             'key' => 'type',
//             'value' => array('key' => 'in', 'value' => 'simple,configurable')
//         )
//     )
// );
// $result = $proxy->catalogProductList((object)array('sessionId' => $sessionId->result, 'filters' => $complexFilter));
// var_dump($result->result);