<?php

$do = \filter_input(\INPUT_GET, 'do');
if ($do!=='sync') {
    echo 'Error';
    exit;
}
if (file_exists('change.xml')) {
    $xml = simplexml_load_file('change.xml');
} else {
    echo 'NONE';
    exit;
    
    $xml = new SimpleXMLElement('<root/>');
    $xml->asXML("change.xml");
}
$timenow = date("YmdHis");
$user = htmlentities($_SERVER['REMOTE_USER']);
$refer = htmlentities($_SERVER['HTTP_REFERER']);
//file_put_contents("change".$timenow, $timenow.':'.$user.':'.$refer.':'.$do);

