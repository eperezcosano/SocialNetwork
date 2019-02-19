<?php
if(!mysql_connect("localhost","vh25774_icaria","HwBM00Zu"))
{
     die('oops connection problem ! --> '.mysql_error());
} else {

	mysql_query("SET NAMES utf8");
}
if(!mysql_select_db("vh25774_icaria"))
{
     die('oops database selection problem ! --> '.mysql_error());
}
?>