<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['user']))
{
 header("Location: index.php");
}
$res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);

$res2=mysql_query("SELECT * FROM users WHERE user_id=".$_GET['id']);
$userRow2=mysql_fetch_array($res2);


if (empty($userRow2['avatar'])) {

	?><img class='ava' src='avatar/default.png'><?php

} else {
	
	if ($userRow2['avatar'] == "uploaded") {
		
			?><img class='ava' src='avatar/<?php echo $userRow2['username'];echo '.';echo $userRow2['avatar_type']?>'><?php
		
	}else {
		
		echo 'error';
		
	}

}

?>