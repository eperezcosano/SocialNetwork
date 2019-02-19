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
$bres=mysql_query("SELECT * FROM blog_posts");

$onlineres=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
$onlinerow=mysql_fetch_array($onlineres);
include 'user_online3.php';
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $lang['HOME']; ?> - <?php echo $userRow['username']; ?></title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
	</head>
	<body class="home">
		
		<?php include 'header.php'; ?>
		<div class="wrpr">
		<div class="userposts">
				<?php
				
				while ($bRow = mysql_fetch_array($bres)) {
					

						?><div class="userpost"><?php
						echo "<p class='post-title'>" . $bRow['tittle'] . "</p>";
						echo "<div class='post-text'>" . $bRow['post'] . "</div>";
						echo "<div class='post-footer'>";
						echo "<a href='user.php?id=" . $bRow['author_id'] . "'><span class='post-autor'><i class='fa fa-user'></i> " . $bRow['username'] . "</span></a>";
						echo "<span class='post-date'><i class='fa fa-clock-o'></i> " . $bRow['post_date'] . "</span>";
						echo "</div>"
						?></div><?php //end of userpost

					}

				?>
			</div><!--end of userposts-->
			</div><!--end of wrpr-->
	</body>
</html>