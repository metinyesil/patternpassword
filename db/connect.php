<?php
date_default_timezone_set('Europe/Istanbul');
$time = date('d.m.Y H:i:s');

    $baglanti = new PDO("mysql:host=localhost;dbname=testlogin", "root", "");
    $baglanti->exec("SET NAMES utf8");
    $baglanti->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>