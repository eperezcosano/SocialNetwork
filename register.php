<?php
session_start();
if(isset($_SESSION['user'])!="")
{
 header("Location: home.php");
}
include_once 'dbconnect.php';

$date = new DateTime();
//$date->modify('+2 hours');
$joindate = $date->format('Y-m-d');
$private = 'FALSE';


 if (isset($_POST['btn-signup'])) {

    $error = array();
    /*$uname = mysql_real_escape_string($_POST['uname']);
	$email = mysql_real_escape_string($_POST['email']);
	$upass = md5(mysql_real_escape_string($_POST['pass'])); */
    if (empty($_POST['uname'])) { 
        $error[] = 'Please Enter a username '; 
    } else {
        $username = mysql_real_escape_string($_POST['uname']);
    }

    if (empty($_POST['email'])) {
        $error[] = 'Please Enter your Email ';
    } else {

        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            //for email validation (refer: http://us.php.net/manual/en/function.filter-var.php)

            $email = mysql_real_escape_string($_POST['email']);
        } else {
            $error[] = 'Your EMail Address is invalid  ';
        }

    }

    if (empty($_POST['pass'])) {
        $error[] = 'Please Enter Your Password ';
    } else {
        $password = md5(mysql_real_escape_string($_POST['pass']));
    }
    if (empty($_POST['cpass'])) {
        $error[] = 'Please Confirm Your Password ';
    }
    if ($_POST['pass'] != $_POST['cpass']) {
    	$error[] = 'Password Do Not Match';
    }
    if (empty($_POST['terms'])) {
        $error[] = 'YOU ARE A ROBOT!';
    }
    if (strlen($_POST['uname']) < '4') {
    $error[] = 'Username too short. 4 characters minimum';
    }
    if (strlen($_POST['pass']) < '4') {
    $error[] = 'Password too short. 4 characters minimum';
    }
    if (empty($error))

    { // If everything's OK...

		$enlace = mysql_connect("localhost", "vh25774_icaria", "HwBM00Zu");
		mysql_select_db("vh25774_icaria", $enlace);

		$resultado = mysql_query("SELECT * FROM users WHERE username='{$_POST['uname']}'", $enlace);
		$num_filas = mysql_num_rows($resultado);

		$enlace2 = mysql_connect("localhost", "vh25774_icaria", "HwBM00Zu");
		mysql_select_db("vh25774_icaria", $enlace2);

		$resultado2 = mysql_query("SELECT * FROM users WHERE email='{$_POST['email']}'", $enlace);
		$num_filas2 = mysql_num_rows($resultado2);

        if ($num_filas == '0' && $num_filas2 == '0' ) { // IF no previous user is using this username.

            mysql_query("INSERT INTO users(username,email,password,joindate,private) VALUES('$username','$email','$password','$joindate','$private')");
            echo "Registered";
            ?><meta http-equiv="refresh" content="0; url=success.html"><?php

		} elseif ($num_filas != '0') {
			echo '<div class="errormsgbox" >That username has already been registered.</div>';
		} elseif ($num_filas2 != '0') {
			echo '<div class="errormsgbox" >That email has already been registered.</div>';
		}


    } else { //If the "error" array contains error msg , display them.... e.g....

        echo '<div class="errormsgbox"> <ul>';
        foreach ($error as $key => $values) {

            echo '  <li>' . $values . '</li>';

        }
        echo '</ul></div>';

    }

} 

// End of the main Submit conditional.

/*	if (empty($_POST['uname']) || empty($_POST['email']) || empty($_POST['pass']) || empty($_POST['cpass']) || empty($_POST['terms'])) {
		echo "<div class='error'>Something is empty...</div>";
	} else {
		if (strlen($_POST['uname']) < "4") {
			echo "<div class='error'>Username is too short. Enter 4 characters as minimum</div>";
		} else {
			$checkuname=mysql_query("SELECT * FROM users WHERE username=".$_POST['uname']);
			if (mysql_num_rows($checkuname) >= "1") {
				echo "<div class='error'>Username already exists</div>";
			} else {
				echo "next";
			}
			
		}
		
	}

 *//*
	if (mysql_query("SELECT * FROM users WHERE username=".$_POST['uname'])) {

		?><script>alert('The username you have entered is already chosed. Please enter another one');</script><?
		header("refresh:1;");

	} else {

		if (mysql_query("SELECT * FROM users WHERE email=".$_POST['email'])) {

			?><script>alert('Already exists an user name with this email!');</script><?

		} else {
			
			if(mysql_query("INSERT INTO users(username,email,password,joindate,private) VALUES('$uname','$email','$upass','$joindate','$private')")){

				header("Location: success.html");

			} else {

				?><script>alert('Error to register you. Please try again...');</script><?
			}

		}
	}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Register</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

<div id="login-form">
<form method="post" name="RegisterForm" id="regform">
<input type="text" name="uname" placeholder="User Name" required />
<input type="email" name="email" placeholder="Your Email" required />
<input type="password" name="pass" id="pass" placeholder="Your Password" required />
<input type="password" name="cpass" id="cpass" placeholder="Confirm Your Password" required />
<div class="check">
<input type="checkbox" required name="terms"><span>I'm not a robot</span>
</div>
<button type="submit" class="bttn" name="btn-signup">Sign Up</button>
<a class="bttn"  href="index.php">Log In</a>
</form>
</div>
</body>
</html>