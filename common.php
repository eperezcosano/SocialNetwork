<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['user']))
{
 header("Location: index.php");
}
$res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);

$lang = $userRow['country'];

switch ($lang) {
  case 'EN':
  $lang_file = 'lang.en.php';
  break;
 
  case 'CAT':
  $lang_file = 'lang.cat.php';
  break;
 
  case 'ES':
  $lang_file = 'lang.es.php';
  break;

  case 'RU':
  $lang_file = 'lang.ru.php';
  break;
 
  default:
  $lang_file = 'lang.en.php';
 
}
 
include_once 'lang/'.$lang_file;
?>