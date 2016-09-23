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
        $node[0]->addAttribute('MRN', uniqid());
        $node[0]->addAttribute('type', 'dx');
        $el = $node[0]->addChild('diagnoses');
            $el[0]->addAttribute('au', 'tc');
            $el[0]->addAttribute('ed', date("YmdHis"));
            $el[0]->addChild('notes', file_get_contents('http://loripsum.net/api/1/short/plaintext'));
            $el[0]->addChild('card', file_get_contents('http://loripsum.net/api/1/short/plaintext'));
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