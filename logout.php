<?php
session_start();
include 'dbconnect.php';

if(!isset($_SESSION['user']))
{
 header("Location: index.php");
}
else if(isset($_SESSION['user'])!="")
{
 header("Location: home.php");
}

if(isset($_GET['logout']))
{
 mysql_query("DELETE FROM user_online WHERE session = '{$_SESSION['user']}'");
 session_destroy();
 unset($_SESSION['user']);
 header("Location: index.php");
}
?>