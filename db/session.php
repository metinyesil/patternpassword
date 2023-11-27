<?php
session_start();
if(empty($_SESSION["pattern"]))
{
    header("location:login.php");
}
?>