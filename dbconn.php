<?php
    $servername = "localhost";
    $username = "seflmar";
    $password = "885748";
    $dbname = "seflmar";
    $link = @mysql_connect($servername,$username,$password) or die('Nelze se pripojit k databazi.');
    @mysql_select_db($dbname, $link) or die('Databaze neexistuje');
    mysql_query ('set names utf8'); 
?>