<?php
    $do = \filter_input(\INPUT_GET, 'do');

    echo $do;
    echo 'test';
$timenow = date("YmdHis");
$user = htmlentities($_SERVER['REMOTE_USER']);
$refer = htmlentities($_SERVER['HTTP_REFERER']);
file_put_contents("change".$timenow, $timenow.':'.$user.':'.$refer.':'.$do);

$xml = new DOMDocument;
$xml_root = $xml->createElement("root");
$xml_lvl1 = $xml->createElement("level 1");
$xml->appendChild($xml_root);
$xml_el = $xml_root->createElement("level 1");
$xml_root->appendChild($xml_el);

$xml->save("change.xml");
