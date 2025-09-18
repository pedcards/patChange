<?php
$do = \filter_input(\INPUT_GET, 'do');
$logfile = 'logs/'.date('Ym').'.csv';

if ($do=='count') {
    $msg = \filter_input(\INPUT_GET, 'to');
    eventlog($msg);
}
else {
    echo 'NULL';
}

function eventlog($text) {
    global $logfile;
    if (getenv('HTTP_CLIENT_IP')) {
        $ipaddress = getenv('HTTP_CLIENT_IP');
    } else if(getenv('HTTP_X_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    } else if(getenv('HTTP_X_FORWARDED')) {
        $ipaddress = getenv('HTTP_X_FORWARDED');
    } else if(getenv('HTTP_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    } else if(getenv('HTTP_FORWARDED')) {
       $ipaddress = getenv('HTTP_FORWARDED');
    } else if(getenv('REMOTE_ADDR')) {
        $ipaddress = getenv('REMOTE_ADDR');
    } else {
        $ipaddress = 'UNKNOWN';
    }
    $out = fopen($logfile,'a');
    fputcsv(
        $out, 
        array(
            date('Ymd|H:i:s'),
            $ipaddress,
            $text
        )
    ); 
    fclose($out);
}
