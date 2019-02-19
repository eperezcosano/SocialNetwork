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

$res2=mysql_query("SELECT * FROM users WHERE user_id=".$_GET['id']);
$userRow2=mysql_fetch_array($res2);

if ($userRow['admin'] == 'TRUE' && $userRow2['private'] == 'TRUE') {
	//pass
	echo "Hello Admin, This Page is only visible by you. This is a private profile so anyone can't view this. 
	The owner either can't view this. The owner only can view itself profile in profile.php and not user.php?id= because that one is for the public";

} elseif (($userRow2['private'] == 'TRUE' && $_GET['id'] == $userRow['user_id']) || ($userRow2['private'] == 'FALSE' && $_GET['id'] == $userRow['user_id'])) {

	header("Location: profile.php");

} elseif ($userRow2['private'] == 'FALSE' && $_GET['id'] !== $userRow['user_id']) {

//pass

} elseif ($userRow2['private'] == 'TRUE' && $_GET['id'] !== $userRow['user_id']) {

		header("Location: 403.html");

} elseif (!isset($userRow2['private'])) {

		header("Location: 404.html");
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $lang['PROFILE_TITLE']; ?>
		    		<?php

		    	 if (empty($userRow2['name'])) {
		    	 	
		    	 	echo $userRow2['username'];
		    	 	
		    	 } else {
		    	 
		    	 	echo $userRow2['name'];
		    	 
		    	 }
		    	 ?><?php echo $lang['PROFILE_TITLE_EN']; ?></title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
	</head>
	<body class="userpg">
		<?php include 'header.php'; ?>
		<div class="content wrpr">
		
		<div class="profilecontent">
			
			
			<div class="pgava">
			  <?php include 'avatar2.php' ?>
			</div>
			
			<div class="userinfo">
			  <div class="nameline">
				<h2 class="pg-name">
					<?php
						if (!empty($userRow2['name'])) {
							
							echo $userRow2['name'];
						}
					?>
				</h2>
				<h2 class="pg-name">
					<?php
						if (!empty($userRow2['lastname'])) {
							
							echo $userRow2['lastname'];
						}
					?>
				</h2>
				<div class="usrconn">
					<?php
					include 'user_online.php';
					?>
				</div>
				<div class='new_message'>

					<?php 
					echo "<a href='message_profile.php?id=" . $_GET['id'] . "'>Send Message</a>"; ?>
				</div>
				</div>
				<p><span class="label"><?php echo $lang['USERNAME']; ?>:</span> <?php echo $userRow2['username'];?></p>
				<p><span class="label"><?php echo $lang['EMAIL']; ?>:</span> <?php echo $userRow2['email'];?></p>
				
					<?php
						if (!empty($userRow2['bio'])) {
							?> <p><span class="label"><?php echo $lang['ABOUTME']; ?>:</span><?
							echo $userRow2['bio'];
						}
					?>
				</p>
				
					<?php
						if ($userRow2['gender'] == "male") {
								?> <p><span class="label"><?php echo $lang['GENDER']; ?>:</span><?
									?> <i class="fa fa-mars"></i><?php
									
								} elseif ($userRow2['gender'] == "female") {
								?> <p><span class="label"><?php echo $lang['GENDER']; ?>:</span><?
									?> <i class="fa fa-venus"></i><?php
								} elseif (!isset($userRow2['gender'])) {
									
								}
					?></p>
				<p><span class="label"><?php echo $lang['JOINDATE']; ?>:</span> <?php echo $userRow2['joindate'];?></p>
				
					<?php
					if (!empty($userRow2['country'])) {
						?><p><span class="label"><?php echo $lang['COUNTRY']; ?>:</span><?
						if ($userRow2['country'] == "ES") {
											echo $lang['ESLANG'];
										}
										if ($userRow2['country'] == "EN") {
											echo $lang['ENLANG'];
										}
										if ($userRow2['country'] == "CAT") {
											echo $lang['CATLANG'];
										}
										if ($userRow2['country'] == "RU") {
											echo $lang['RULANG'];
										}
					} else {
						
					}
					
					?>
				</div> <!--#edit ava img-->
			</div><!---#userinfo-->
		</div><!--#profilecontent-->
		</div><!--#content wrpr-->
		<div class="profileuserblog">
			<?php include 'blog_profile2.php'; ?>
		</div><!--#profileuserblog-->
	</body>
</html>