<?php
session_start();
include_once 'dbconnect.php';

if(isset($_SESSION['user'])!="")
{
 header("Location: home.php");
}
/*if(isset($_POST['btn-login']))
{
 $email = mysql_real_escape_string($_POST['email']);
 $upass = mysql_real_escape_string($_POST['pass']);
*/$res=mysql_query("SELECT * FROM users WHERE email='$email'");
 $row=mysql_fetch_array($res);
 /*
 if($row['password']==md5($upass))
 {
  $_SESSION['user'] = $row['user_id'];
  header("Location: home.php");
 }
 else
 {
  ?>
        <script>alert('wrong details');</script>
        <?php
 }
 */
if (isset($_POST['btn-login'])) {

$error = array();
/*$uname = mysql_real_escape_string($_POST['uname']);
$email = mysql_real_escape_string($_POST['email']);
$upass = md5(mysql_real_escape_string($_POST['pass'])); */
if (empty($_POST['email'])) {
    $error[] = 'Please Enter your Email ';
} else {
	$email = mysql_real_escape_string($_POST['email']);
}
if (empty($_POST['pass'])) {
    $error[] = 'Please Enter Your Password ';
} else {
    $upass = md5(mysql_real_escape_string($_POST['pass']));
}
if (empty($error))

{ // If everything's OK...

	$enlace = mysql_connect("localhost", "vh25774_icaria", "HwBM00Zu");
	mysql_select_db("vh25774_icaria", $enlace);

	$resultado = mysql_query("SELECT * FROM users WHERE email='{$_POST['email']}'", $enlace);
	$num_filas = mysql_num_rows($resultado);

    if ($num_filas == '1') { // IF no previous user is using this username.

        $done="1";

	} else {
		echo '<div class="errormsgbox" >Email or Password Incorrect</div>';
	}


} else { //If the "error" array contains error msg , display them.... e.g....

    echo '<div class="errormsgbox"> <ul>';
    foreach ($error as $key => $values) {

        echo '  <li>' . $values . '</li>';

    }
    echo '</ul></div>';

}

}

if ($done == '1') {

	$res=mysql_query("SELECT * FROM users WHERE email='{$_POST['email']}'");
	$row=mysql_fetch_array($res);

	if ($row['password']==$upass) {
		$_SESSION['user'] = $row['user_id'];
	  header("Location: home.php");
	  echo "Done";
	  ?><meta http-equiv="refresh" content="0; url=home.php"><?php
	} else {
		echo '<div class="errormsgbox" >Email or Password Incorrect</div>';
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Icaria</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body class="front">

<div id="login-form">
<form method="post">

<input type="text" name="email" placeholder="Your Email" required />

<input type="password" name="pass" placeholder="Your Password" required />

<button type="submit" class="bttn" name="btn-login">Log In</button>

<a class="bttn" href="register.php">Sign Up Here</a></td>

</form>
</div>

</body>
</html>