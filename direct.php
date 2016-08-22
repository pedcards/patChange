<?php
$timenow = date("YmdHis");
//$file = '../patlist/change.xml';
$file = 'change.xml';
$do = \filter_input(\INPUT_GET, 'do');
if ($do=='root') {
    $xml = new DOMDocument();
    $ele = $xml->createElement('root');
    $xml->appendChild($ele);
    $xml->save($file);
    echo 'root';
    exit;
}
if ($do=='save') {
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
    $out = $xml->saveXML();
    echo $out;
    exit;
} 
else {
    echo 'NULL';
}