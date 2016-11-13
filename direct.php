<?php
$timenow = date("YmdHis");
$test = \filter_input(\INPUT_GET, 'test');
$do = \filter_input(\INPUT_GET, 'do');
$path = '../' . (($test) ? 'test' : 'pat') . 'list/';
$file = $path . 'change.xml';
$sysop = 'ussgHSjm3HpytUncU6Sg1jimxj7TiJ';
if ($do=='root') {
    $xml = new SimpleXMLElement('<root />');
    $xml->asXML($file);
    echo 'root';
    exit;
}
if ($do=='lorem') {
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
if ($do=='full') {
    $xml = new DOMDocument();
    $xml->preserveWhiteSpace = false;
    $xml->formatOutput = true;
    $xml->load($path . 'currlist.xml');
    echo $xml->saveXML();
    exit;
}
if ($do=='err200') {                // filesize exceeding 500kb, something is wrong
    pov($sysop,'Excess filesize error');
    exit;
}
if ($do=='err999') {                // bad error: all currlists failed
    pov($sysop,'EPIC FAIL');
    exit;
}
if ($do=='log') {
    $log = file_get_contents($path . 'logs/' . date('Ym') . '.log');
    echo "<font size='2' face='Arial'>";
    echo nl2br($log);
    exit;
}
else {
    echo 'NULL';
}

function pov($user,$msg) {
    curl_setopt_array($ch = curl_init(), array(
        CURLOPT_URL => "https://api.pushover.net/1/messages.json",
        CURLOPT_POSTFIELDS => array(
            "token" => "ab9z9qxvkakctdhamf486ice9r89dv",
            "user" => $user,
            "title" => "CHIPOTLE",
            "message" => $msg,
            "sound" => "echo"
        ),
        CURLOPT_SAFE_UPLOAD => true,
    ));
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
}