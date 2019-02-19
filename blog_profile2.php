<?php

session_start();

$bres=mysql_query("SELECT * FROM blog_posts ORDER BY post_id DESC");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="style.css" type="text/css" />
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
	</head>
	<body>
		<div class="userblog">
			<div class="userposts">
				<?php

				if ($userRow['admin'] == 'TRUE') {
					echo "Hi admin";
					while ($bRow = mysql_fetch_array($bres)) {
						
						if ($bRow['author_id'] == $_GET['id']) {
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
							<p><button type="submit" class="bttn" name="deletesinglepost" value="<?php echo $bRow['post_id']; ?>"><i class="fa fa-trash-o"></i> <?php echo "Delete as ADMIN"; ?></button></p>
							</div>
							</div>
							</form>

							<?php //end of userpost

						} else {
							//not display
						}
					}
				} else {

					while ($bRow = mysql_fetch_array($bres)) {
						
						if ($bRow['author_id'] == $_GET['id']) {

							?><div class="userpost"><?php
							echo "<p class='post-title'>" . $bRow['tittle'] . "</p>";
							echo "<div class='post-text'>" . $bRow['post'] . "</div>";
							echo "<div class='post-footer'>";
							echo "<span class='post-autor'><i class='fa fa-user'></i> " . $bRow['username'] . "</span>";
							echo "<span class='post-date'><i class='fa fa-clock-o'></i> " . $bRow['post_date'] . "</span>";
							echo "</div>";
							?></div><?php //end of userpost

						} else {
							//not display
						}
					}
				}
				?>
			</div><!--end of userposts-->
		</div><!--end of userblog-->
	</body>
</html>