<?php include_once 'common.php'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $lang['USERLIST']; ?></title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
	</head>
	<body class="profileslistpg">

<?php
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection = 'utf8_unicode_ci'");
//$con=mysqli_connect("localhost","vh25774_icaria","HwBM00Zu","vh25774_icaria");

// Check connection
//if (mysqli_connect_errno())
//{
//echo "Failed to connect to MySQL: " . mysqli_connect_error();
//}

//$result = mysql_query($con,"SELECT * FROM users");

session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['user']))
{
 header("Location: index.php");
}
$res=mysql_query("SELECT * FROM users");

$online=mysql_query("SELECT * FROM users WHERE user_id='{$_SESSION['user']}'");
$onlinerow= mysql_fetch_array($online);

include 'user_online3.php';

echo "<div class='usertable'>";


while($row = mysql_fetch_array($res))
{

if ($row['private'] == 'TRUE' && $onlinerow['admin'] == 'TRUE' || $row['private'] == 'TRUE' && $row['user_id'] == $onlinerow['user_id']) {


	echo "<div class='itmpri'>";

	if (empty($row['avatar'])) {

		?><div class='ava'><img class='ava' src='avatar/default.png'></div><?php

	} else {
		
		if ($row['avatar'] == "uploaded") {
			
				echo "<div class='ava'><img src='/avatar/" . $row['username'] . "." . $row['avatar_type'] . "'></div>";
			
		}else {
			
			echo 'error';
			
		}

	}

	if (empty($row['name'])) {

		echo "<h2>" . $row['username'] . "</h2>";
		include 'user_online2.php';

	} else {
		
		echo "<h2>" . $row['name'] . " ";
		echo "" . $row['lastname'] . "</h2>";
		include 'user_online2.php';

	}

	if (empty($row['gender'])) {

		echo "<p> </p>";

	} else {
		
		if ($row['gender'] == 'male') {

			echo "<p><i class='fa fa-odnoklassniki'></i> " . $lang['MALE'] . "</p>";

		} else {

			echo "<p><i class='fa fa-odnoklassniki'></i> " . $lang['FEMALE'] . "</p>";
		}
	}

	if (empty($row['country'])) {

		echo "<p> </p>";

	} else {
		
		switch ($row['country']) {
			case 'EN':
				echo "<i class='fa fa-comments-o'></i> " . $lang['ENLANG'] . "</p>";
				break;
			case 'ES':
				echo "<i class='fa fa-comments-o'></i> " . $lang['ESLANG'] . "</p>";
				break;
			case 'CAT':
				echo "<i class='fa fa-comments-o'></i> " . $lang['CATLANG'] . "</p>";
				break;
			case 'RU':
				echo "<i class='fa fa-comments-o'></i> " . $lang['RULANG'] . "</p>";
				break;
			default:
				echo "<i class='fa fa-comments-o'></i> " . $lang['ENLANG'] . "</p>";
				break;
		}
		
		echo "<p><i class='fa fa-user'></i> <a href='/user.php?id=" . $row['user_id'] . "'>" . $lang['VIEWPROFILE'] . "</a></p>";
	}

} else {

	// not display
}

	

	if ($row['private'] == 'FALSE') {

		echo "<div class='itm'>";

		if (empty($row['avatar'])) {

			?><div class='ava'><img class='ava' src='avatar/default.png'></div><?php

		} else {
			
			if ($row['avatar'] == "uploaded") {
				
					echo "<div class='ava'><img src='/avatar/" . $row['username'] . "." . $row['avatar_type'] . "'></div>";
				
			}else {
				
				echo 'error';
				
			}

		}

		if (empty($row['name'])) {

			echo "<h2>" . $row['username'] . "</h2>";
			include 'user_online2.php';


		} else {
			
			echo "<h2>" . $row['name'] . " ";
			echo "" . $row['lastname'] . "</h2>";
			include 'user_online2.php';

		}

		if (empty($row['gender'])) {

			echo "<p> </p>";

		} else {
			
			if ($row['gender'] == 'male') {

				echo "<p><i class='fa fa-odnoklassniki'></i> " . $lang['MALE'] . "</p>";

			} else {

				echo "<p><i class='fa fa-odnoklassniki'></i> " . $lang['FEMALE'] . "</p>";
			}
		}

		if (empty($row['country'])) {

			echo "<p> </p>";

		} else {
			
			switch ($row['country']) {
				case 'EN':
					echo "<i class='fa fa-comments-o'></i> " . $lang['ENLANG'] . "</p>";
					break;
				case 'ES':
					echo "<i class='fa fa-comments-o'></i> " . $lang['ESLANG'] . "</p>";
					break;
				case 'CAT':
					echo "<i class='fa fa-comments-o'></i> " . $lang['CATLANG'] . "</p>";
					break;
				case 'RU':
					echo "<i class='fa fa-comments-o'></i> " . $lang['RULANG'] . "</p>";
					break;
				default:
					echo "<i class='fa fa-comments-o'></i> " . $lang['ENLANG'] . "</p>";
					break;
			}
			

		}

		echo "<p><i class='fa fa-user'></i> <a href='/user.php?id=" . $row['user_id'] . "'>" . $lang['VIEWPROFILE'] . "</a></p>";
	}
// echo "<div class='ava'><img src='/avatar/" . $row['username'] . "." . $row['avatar_type'] . "'></div>";
// echo "<h2>" . $row['name'] . " ";
// echo "" . $row['lastname'] . "</h2>";
// echo "<p><i class='fa fa-odnoklassniki'></i> " . $row['gender'] . "</p>";
// echo "<p><i class='fa fa-map-marker'></i> " . $row['country'] . "</p>";
// echo "<p><i class='fa fa-user'></i> <a href='/user.php?id=" . $row['user_id'] . "'> View Profile </a></p>";

//echo "<td><img src='/avatar/" . $row['username'] . ".jpeg' /></td>";
//echo "<td>" . $avatarurl . "</td>";
echo "</div>";
}
echo "</div>";

//mysqli_close($con);
?>

</body>
</html>