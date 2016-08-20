<?php
$file = '../patlist/change.xml';
//$file = 'change.xml';
$do = \filter_input(\INPUT_GET, 'do');
if ($do!=='sync') {
    echo 'Error';
    exit;
}
if (file_exists($file)) {
    $xml = simplexml_load_file($file);
    echo 'Loaded';
} else {
    $xml = new SimpleXMLElement('<root/>');
    $xml->asXML($file);
    echo 'NONE';
    exit;
}
$timenow = date("YmdHis");

$node = $xml[0]->addChild('node');
$node[0]->addAttribute('date', $timenow);
$node[0]->addChild('child');

$xml->asXML($file);

echo $xml->asXML();
