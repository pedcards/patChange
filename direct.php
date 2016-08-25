<?php
$timenow = date("YmdHis");
$file = '../patlist/change.xml';
$do = \filter_input(\INPUT_GET, 'do');
if ($do=='root') {
    $xml = new DOMDocument();
    $ele = $xml->createElement('root');
    $xml->appendChild($ele);
    $xml->save($file);
    echo 'root';
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
    printf ("<pre>%s</pre>", htmlentities ($xml->saveXML()));
    exit;
} 
else {
    echo 'NULL';
}