<?php


session_start();

$time=time();
$host="localhost"; // Host name
$username="vh25774_icaria"; // Mysql username
$password="HwBM00Zu"; // Mysql password
$db_name="vh25774_icaria"; // Database name
$tbl_name="user_online"; // Table name

// Connect to server and select databse

if (!isset($_SESSION['user'])) {

	header("Location: index.php");

} else {

	mysql_connect("$host", "$username", "$password")or die("cannot connect to server");
	mysql_select_db("$db_name")or die("cannot select DB");

	$res=mysql_query("SELECT * FROM users WHERE user_id='{$_SESSION['user']}'");
	$userRow=mysql_fetch_array($res);

	$res2=mysql_query("SELECT * FROM users WHERE user_id='{$_GET['id']}'");
	$userRow2=mysql_fetch_array($res2);

	

	if (!isset($userRow2['user_id'])) {
		
		//echo "Hola " . $userRow['username'] . "<br>";

		$sql="SELECT * FROM $tbl_name WHERE session='{$userRow['user_id']}'";
		$result=mysql_query($sql);
		$count=mysql_num_rows($result);

		if($count=="0"){

			$sql1="INSERT INTO $tbl_name(session, time)VALUES('{$userRow['user_id']}', '$time')";
			$result1=mysql_query($sql1);
			//echo "En base de datos y conectado!<br>";
			//echo $time;
			?><img src='/img/online.png'></img><?php

		} elseif ($count=="1") {
			
			$sql2="UPDATE $tbl_name SET time='$time' WHERE session = '{$userRow['user_id']}'";
			$result2=mysql_query($sql2);
			//echo "Actualizado y conectado!<br>";
			//echo $time;
			?><img src='/img/online.png'></img><?php

		} else {
			echo "Error 1";
		}

	} elseif (isset($userRow2['user_id'])) {
		
		//echo "Hola " . $userRow['username'] . "<br>";

		$sql="SELECT * FROM $tbl_name WHERE session='{$userRow['user_id']}'";
		$result=mysql_query($sql);
		$count=mysql_num_rows($result);

		if($count=="0"){

			$sql1="INSERT INTO $tbl_name(session, time)VALUES('{$userRow['user_id']}', '$time')";
			$result1=mysql_query($sql1);
			//echo "En base de datos y conectado!<br>";
			//echo $time;
			

		} elseif ($count=="1") {
			
			$sql2="UPDATE $tbl_name SET time='$time' WHERE session = '{$userRow['user_id']}'";
			$result2=mysql_query($sql2);
			//echo "Actualizado y conectado!<br>";
			//echo $time;
			

		} else {
			echo "Error 1";
		}


		//echo "Tu eres " . $userRow['username'] . "<br>";

		//echo "Combrobando el estado de " . $userRow2['username'] . "<br>";

		$time_check=time() - 60;
		$time_check2=time() - 300;
		$sql4="SELECT * FROM $tbl_name WHERE session = '{$userRow2['user_id']}'";
		$result4=mysql_query($sql4);
		$userRow3=mysql_fetch_array($result4);

		//echo "Ahora " . $userRow3['time'] . "<br>";
		//echo "Limite " . $time_check . "<br>";

		if (!isset($userRow3['time'])) {
			?><img src='/img/offline2.png'></img><?php
		} else {
			if ($userRow3['time'] > $time_check2) {
				if ($userRow3['time'] > $time_check) {
					?><img src='/img/online.png'></img><?php
				} elseif ($userRow3['time'] <= $time_check) {
					?><img src='/img/offline1.png'></img><?php
				}
				
			} elseif ($userRow3['time'] <= $time_check2) {
				mysql_query("DELETE FROM $tbl_name WHERE session = '{$userRow2['user_id']}'");
				?><img src='/img/offline2.png'></img><?php
			} else {
				echo "Error 2";
			}
			
		}
		

/*
		if ($userRow3['time'] < $time_check) {
			
			//echo "Usuario fuera de tiempo<br>";
			mysql_query("DELETE FROM $tbl_name WHERE session = '{$userRow2['user_id']}'");
			//echo "Desconectado";

		} elseif ($userRow3['time'] >= $time_check) {
			
			//echo "Conectado";
			?><img src='/img/online.png'></img><?php

		} else {

			echo "Error 2";

		}
		*/

	}
	

}

// mysql_close();
?>