<?php
session_start();
  $con = mysqli_connect('localhost','j431miyo','') or die("接続失敗");
  mysqli_select_db($con, 'j431miyoP') or die("選択失敗");
  mysqli_query($con, 'SET NAMES utf8');

  $cost = $_GET['str'];
  $chr = $_GET['chr'];
  $sql = "UPDATE shop set $chr = $chr + 1";
  $res = mysqli_query($con, $sql) or die("エラー");
  $sql = "UPDATE shop set money = money - $cost";
  $res = mysqli_query($con, $sql) or die("エラー");
?>