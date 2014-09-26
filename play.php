<?php 

$client = new SoapClient('http://beta.purepharma.com/index.php/api/v2_soap/?wsdl');

// If some stuff requires api authentification,
// then get a session token
$session = $client->login('rojan', 'rojan123');
$complexFilter = array(
    'complex_filter' => array(
        array(
            'key' => 'type',
            'value' => array('key' => 'in', 'value' => 'simple,configurable')
        )
    )
);
$result = $client->catalogProductList($session, $complexFilter);

var_dump($result);