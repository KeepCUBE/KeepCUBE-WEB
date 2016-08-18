<?php

    $host = '213.220.195.7';
    $port = 8888;

    $code = $_GET["code"];
    $action = $_GET["action"];
    switch ($action)
    {
        case "on":
            $action = 1;
            break;
        case "off":
            $action = 0;
            break;
    }

    $fp = fsockopen($host, $port, $errno, $errstr, 2);

    if (!$fp) {
        echo "$errstr ($errno)<br />\n";
    } else {
        while (!feof($fp)) {
            $msg = trim(fgets($fp, 128));
            if($msg == "SRVCONF")
            {
                fwrite($fp, "CLNCONF#DTS{$code}A{$action}E");
                break;
            }
        }
        fclose($fp);

        header('Location: '.$_SERVER['HTTP_REFERER']);
    }