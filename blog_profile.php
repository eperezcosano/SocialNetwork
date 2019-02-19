<?php

session_start();
include_once 'dbconnect.php';


if(!isset($_SESSION['user']))
{
 header("Location: index.php");
}

$res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);

$bres=mysql_query("SELECT * FROM blog_posts ORDER BY post_id DESC");


if (isset($_POST['post'])) {

	if (empty($_POST['tittlepost']) || empty($_POST['textpost']) || (empty($_POST['tittlepost']) && empty($_POST['textpost']))) {
		
		?><div class="error"><?php echo $lang['FILLERROR']; ?></div><?php

	} elseif (!empty($_POST['tittlepost']) && !empty($_POST['textpost'])) {
		
		$date = new DateTime();
		$post_date = $date->format('Y-m-d H:i');
		mysql_query("INSERT INTO blog_posts(username, tittle, post, author_id, post_date)VALUES('{$userRow['username']}', '{$_POST['tittlepost']}', '{$_POST['textpost']}', '{$userRow['user_id']}', '$post_date')");
		?><meta http-equiv="refresh" content="0"><?
	} else {

		echo "Something went wrong...";

	}
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="style.css" type="text/css" />
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
	</head>
	<body>
		<div class="postblog">
			<form method="post" name="blogform">
				<p><input name="tittlepost" class="cstmfld" type="text" placeholder="<? echo $lang['TITTLE']; ?>" required></input></p>
				<!--<p><input name="textpost" class="cstmfld" type="text" size="100" placeholder="<? echo $lang['WRITESOMETHING']; ?>" required></input></p>-->
				<p><textarea name="textpost" class="cstmfld" rows="5" placeholder="<? echo $lang['WRITESOMETHING']; ?>" required></textarea></p>
				<p class="rght"><button type="submit" class="bttn" name="post"><i class="fa fa-paper-plane"></i> <?php echo $lang['POST']; ?></button></p>
			</form>
		</div> <!--end of postblog-->
		<div class="userblog">
			<div class="userposts">
				<?php
				
				while ($bRow = mysql_fetch_array($bres)) {
					
					if ($bRow['author_id'] == $userRow['user_id']) {
						if (isset($_POST['deletesinglepost'])) {

							mysql_query("DELETE FROM blog_posts WHERE post_id = '{$_POST['deletesinglepost']}'");
							?><meta http-equiv="refresh" content="0"><?

						}

						?>
						<form name="singlepostform" method="post">
						<div class="userpost">
						<?php
						echo "<p class='post-title'>" . $bRow['tittle'] . "</p>";
						echo "<div class='post-text'>" . $bRow['post'] . "</div>";
						echo "<div class='post-footer'>";
						echo "<span class='post-autor'><i class='fa fa-user'></i> " . $bRow['username'] . "</span>";
						echo "<span class='post-date'><i class='fa fa-clock-o'></i> " . $bRow['post_date'] . "</span>";
						echo "</div>";
						?>
						<div class="deletepost">
						<p><button type="submit" class="bttn" name="deletesinglepost" value="<?php echo $bRow['post_id']; ?>"><i class="fa fa-trash-o"></i> <?php echo $lang['DELETEPOST']; ?></button></p>
						</div>
						</div>
						</form>

						<?php //end of userpost
						

					} else {
						//not display
					}
				}

				?>
			</div><!--end of userposts-->
		</div><!--end of userblog-->
	</body>
</html>