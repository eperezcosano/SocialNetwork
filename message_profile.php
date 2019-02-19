<?php
session_start();
include_once 'dbconnect.php';

include 'common.php';


if(!isset($_SESSION['user']))
{
 header("Location: index.php");
}
$res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);

$onlineres=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
$onlinerow=mysql_fetch_array($onlineres);
include 'user_online3.php';

$reciverres=mysql_query("SELECT * FROM users WHERE user_id=".$_GET['id']);
$reciverRow=mysql_fetch_array($reciverres);


if ($userRow['admin'] == 'TRUE' && $reciverRow['private'] == 'TRUE') {
	//pass
	echo "Hello Admin, This Page is only visible by you. This is a private profile so anyone can't view this. 
	The owner either can't view this. The owner only can view itself profile in profile.php and not user.php?id= because that one is for the public";

} elseif (($reciverRow['private'] == 'TRUE' && $_GET['id'] == $userRow['user_id']) || ($reciverRow['private'] == 'FALSE' && $_GET['id'] == $userRow['user_id'])) {

	header("Location: profile.php");

} elseif ($reciverRow['private'] == 'FALSE' && $_GET['id'] !== $userRow['user_id']) {

$check_con = mysql_query("SELECT hash FROM message_group WHERE (user_one='{$userRow['user_id']}' AND user_two='{$reciverRow['user_id']}') OR (user_one='{$reciverRow['user_id']}' AND user_two='{$userRow['user_id']}')");
$count_con = mysql_num_rows($check_con);

if ($count_con == 1) {
	
	$get_hash = mysql_query("SELECT * FROM message_group WHERE (user_one='{$userRow['user_id']}' AND user_two='{$reciverRow['user_id']}') OR (user_one='{$reciverRow['user_id']}' AND user_two='{$userRow['user_id']}')");
	$get_hash_row= mysql_fetch_array($get_hash);
	echo "<meta http-equiv='refresh' content='0; url=conversations.php?hash=" . $get_hash_row['hash'] . "'>";
} else {
	//pass because user dosnt have started a conversation
}


} elseif ($reciverRow['private'] == 'TRUE' && $_GET['id'] !== $userRow['user_id']) {

		header("Location: 403.html");

} elseif (!isset($reciverRow['private'])) {

		header("Location: 404.html");
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include_once 'header.php'; ?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="style.css" type="text/css" />
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
	</head>
	<body>
		<div class="postblog">
			<form method="post" name="messageform">
				<?
				if (isset($_POST['send'])) {
	
	if (empty($_POST['message'])) {
		
		?><div class="error"><?php echo $lang['FILLERROR']; ?></div><?php

	} elseif (!empty($_POST['message'])) {
		
		//$date = new DateTime();
		//$m_date = $date->format('Y-m-d H:i');
		$random_number = rand();
		mysql_query("INSERT INTO message_group(user_one, user_two, hash) VALUES('{$userRow['user_id']}', '{$reciverRow['user_id']}', '$random_number')");
		mysql_query("INSERT INTO messages(group_hash, from_id, message, readed) VALUES('$random_number', '{$userRow['user_id']}', '{$_POST['message']}', '0')");
		echo "<p>Conversation Started</p>";
		echo "<meta http-equiv='refresh' content='0; url=conversations.php?hash=" . $random_number . "'>";

	} else {

		echo "Something went wrong...";
	}
}
				?>
				<p><textarea name="message" class="cstmfld" rows="5" placeholder="<? echo $lang['WRITESOMETHING']; ?>" required></textarea></p>
				<p class="rght"><button type="submit" class="bttn" name="send"><i class="fa fa-envelope"></i> <?php echo "" . $lang['SEND'] . " " . $lang['TO'] . " " . $reciverRow['username'] . ""; ?></button></p>
			</form>
		</div> <!--end of postblog-->
	</body>
</html>
