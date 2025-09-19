<?php
$do = \filter_input(\INPUT_GET, 'do');
$msg = \filter_input(\INPUT_GET, 'to');
$logfile = 'logs/'.date('Ym').'.csv';
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

if ($do=='count') {
    eventlog($msg);
}
if ($do=='show' & $msg=='all'){
    eventlog('webshow');
    $log = file_get_contents($logfile);
    echo "<font size='2' face='Arial'>";
    echo nl2br($log);
}
else {
    header("HTTP/1.0 404 Not Found");
    echo "<h1>Not Found</h1>";
    echo "<p>The requested resource does not exist on this server.</p>";
    exit();
}

function eventlog($text) {
    global $logfile, $ipaddress;
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
