<?php
$timenow = date("YmdHis");
$test = \filter_input(\INPUT_GET, 'test');
$do = \filter_input(\INPUT_GET, 'do');
$file = '../' . (($test) ? 'test' : 'pat') . 'list/change.xml';
if ($do=='root') {
    $xml = new SimpleXMLElement('<root />');
    $xml->asXML($file);
    echo 'root';
    exit;
}
if ($do=='add') {
    $xml = (simplexml_load_file($file)) ?: new SimpleXMLElement('<root />');
    $node = $xml[0]->addChild('node');
    $node[0]->addAttribute('id', uniqid());
    $ele1 = $node[0]->addChild('name',  uniqid());
    $xml->asXML($file);
    echo 'add';
    exit;
}
if ($do=='unlink') {
    // Need for a currlock?
    unlink($file);
    echo 'unlink';
    exit;
}
if ($do=='get') {
    if (!file_exists($file)) {
        echo 'NONE';
        exit;
    }
    // need decryption?
    $xml = new DOMDocument();
    $xml->preserveWhiteSpace = false;
    $xml->formatOutput = true;
    $xml->load($file);
    echo $xml->saveXML();
    exit;
} 
else {
    echo 'NULL';
}