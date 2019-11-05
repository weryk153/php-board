<?php 

$servername = '166.62.28.131';
$username = 'group6';
$password = 'ht6puorg30rtm';
$dbname = 'mtr03group6';

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->query('SET NAMES UTF8');
$conn->query("SET time_zone = '+08:00'");
if ($conn->connect_error) {
  die("connection failed: " . $conn->connect_error);
  }
?>