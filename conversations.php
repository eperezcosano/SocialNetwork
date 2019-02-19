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

$check_hash = mysql_query("SELECT * FROM message_group WHERE hash='{$_GET['hash']}'");
$num_hash = mysql_num_rows($check_hash);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="style.css" type="text/css" />
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
		<?php include_once 'header.php'; ?>
	</head>
	<body class="profileslistpg">
	</body>
</html>
<?

if (isset($_GET['hash']) && !empty($_GET['hash']) && $num_hash == '1') {
	
	echo "Show messages";
	$hash = $_GET['hash'];
	$message_query = mysql_query("SELECT * FROM messages WHERE group_hash='$hash' ORDER BY id ASC");
	while ($run_message = mysql_fetch_array($message_query)) {
		
		$from_id = $run_message['from_id'];
		$message = $run_message['message'];

		$user_query = mysql_query("SELECT * FROM users WHERE user_id='$from_id'");
		$run_user = mysql_fetch_array($user_query);

		$check_readed = $run_message['readed'];

		if ($from_id == $userRow['user_id']) {
			$deliver = $lang['YOU'];
			if ($check_readed == 0) {
				$icon = "<i class='fa fa-angle-right'></i>";
			} else {
				$icon = "<i class='fa fa-angle-double-right'></i>";
			}
			
		} elseif ($from_id == $run_user['user_id']) {
			$deliver = $run_user['username'];
			
			if ($check_readed == 0) {
				$icon = "· ";
				mysql_query("UPDATE messages SET readed='1' WHERE group_hash='$hash' AND from_id='$from_id'");
				echo "<meta http-equiv='refresh' content='0; url='>";
			} else {
				$icon = "<i class='fa fa-angle-double-left'></i>";
			}
			
		}


		echo "<p>" . $icon . " <b>" . $deliver . "</b></br>" . $message . "</p>";

	}

	?>

	</br>
	<div class="postblog">
		<form method="post" name="messageform">
			<?php

			if (isset($_POST['message']) && !empty($_POST['message'])) {

				mysql_query("INSERT INTO messages(group_hash, from_id, message) VALUES('$hash', '{$userRow['user_id']}', '{$_POST['message']}')");
				echo "<meta http-equiv='refresh' content='0; url='>";
				//header('location: conversations.php?hash='.$hash);

			}

			?>
			<p><textarea name="message" class="cstmfld" rows="5" placeholder="<? echo $lang['WRITESOMETHING']; ?>" required></textarea></p>
			<p class="rght"><button type="submit" class="bttn" name="send"><i class="fa fa-envelope"></i> <?php echo "" . $lang['SEND'] . ""; ?></button></p>
		</form>
	</div> <!--end of postblog-->

	<?php

} elseif (!isset($_GET['hash'])) {
	
	echo "Select conversation";
	$get_con = mysql_query("SELECT `hash`, `user_one`, `user_two` FROM message_group WHERE user_one='{$userRow['user_id']}' OR user_two='{$userRow['user_id']}'");

	echo "<div class='usertable'>";
	/*echo "<div class='itm'>";
		echo "<div class='ava'><img src='/img/plus.jpeg'></div>";
		echo "<h2>New Conversation</h2>";
	echo "</div>";*/
	while ($run_con = mysql_fetch_array($get_con)) {
		
		$hash = $run_con['hash'];
		$user_one = $run_con['user_one'];
		$user_two = $run_con['user_two'];

		if ($user_one == $userRow['user_id']) {
			
			$select_id = $user_two;

		} else {
			
			$select_id = $user_one;

		}

		$user_get = mysql_query("SELECT * FROM users WHERE user_id='$select_id'");
		$run_user = mysql_fetch_array($user_get);
		$select_username = $run_user['username'];

		echo "<div class='itm'>";
		echo "<a href='conversations.php?hash=$hash'></a>";

		if (empty($run_user['avatar'])) {

					?><div class='ava'><img class='ava' src='avatar/default.png'></div><?php

		} else {
					
			if ($run_user['avatar'] == "uploaded") {
				
					echo "<div class='ava'><img src='/avatar/" . $run_user['username'] . "." . $run_user['avatar_type'] . "'></div>";
				
			} else {
				
				echo 'error';
				
			}

		}

		if (empty($run_user['name'])) {

			echo "<h2>" . $run_user['username'] . "</h2>";
			include 'user_online2_m.php';

		} else {
			
			echo "<h2>" . $run_user['name'] . " ";
			echo "" . $run_user['lastname'] . "</h2>";
			include 'user_online2_m.php';

		}
		

		$lastm=mysql_query("SELECT * FROM messages WHERE group_hash='$hash' ORDER BY id DESC");
		$lastm_row=mysql_fetch_array($lastm);

		$check_readed = $lastm_row['readed'];
		if ($lastm_row['from_id'] == $userRow['user_id']) {
			$deliver = $lang['YOU'];
			if ($check_readed == 0) {
				$icon = "<i class='fa fa-angle-right'></i>";
			} else {
				$icon = "<i class='fa fa-angle-double-right'></i>";
			}
		} elseif ($lastm_row['from_id'] == $run_user['user_id']) {
			$deliver = $select_username;
			if ($check_readed == 0) {
				$nonreaded_query = mysql_query("SELECT * FROM messages WHERE readed='0' AND group_hash='$hash'");
				$num_non_readed = mysql_num_rows($nonreaded_query);
				$icon = "<b>(" . $num_non_readed . ")</b>";
			} else {
				$icon = "<i class='fa fa-angle-double-left'></i>";
			}
		}
		echo "<div class=messagebox><br>" . $icon . " " . $lastm_row['message'] . "</div>";
		echo "</div>";
		
	}
	echo "</div>";

} else {

	//echo "<meta http-equiv='refresh' content='0; url=404.html'>";
	header('location: 404.html');
}



?>
