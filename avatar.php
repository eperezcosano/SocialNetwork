<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['user']))
{
 header("Location: index.php");
}
$res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);

if (empty($userRow['avatar'])) {

	?><img class='ava' src='avatar/default.png'><?php

} else {
	
	if ($userRow['avatar'] == "uploaded") {
		
			?><img class='ava' src='avatar/<?php echo $userRow['username'];echo '.';echo $userRow['avatar_type']?>'><?php
		
	}else {
		
		echo 'error';
		
	}

}

?>