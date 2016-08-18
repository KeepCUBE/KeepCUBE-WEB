<?php

$host = '213.220.195.7';

$port = 8888;

$fp = fsockopen($host, $port, $errno, $errstr, 30);
if (!$fp) {
    echo "$errstr ($errno)<br />\n";
} else {
    echo "True\n";
    while (!feof($fp)) {
        $msg = trim(fgets($fp, 128));
        echo "-$msg-\n";
        $msg == "SRVCONF" ? fwrite($fp, "CLNCONF") : print("Nepřišel SRVCONF");
    }
    fclose($fp);
}