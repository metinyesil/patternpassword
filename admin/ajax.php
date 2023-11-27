<?php
session_start();
include '../db/connect.php';

  $receivedPattern = $_POST['pattern'];

  $kontrol = $baglanti->prepare("SELECT * FROM users WHERE pattern=?");
  $kontrol->execute([$receivedPattern]);
  $say = $kontrol->rowCount();

  if($say == 1)
  {
    $_SESSION['pattern'] = sha1("testregex".$receivedPattern."testregex");
    echo "success";
  }
  else{
    echo "error";
  }
?>
