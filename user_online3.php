<?php

$result=mysql_query("SELECT * FROM user_online WHERE session='{$onlinerow['user_id']}'");
$count=mysql_num_rows($result);
$time=time();

if($count=="0"){

	mysql_query("INSERT INTO user_online(session, time)VALUES('{$onlinerow['user_id']}', '$time')");
	/*echo "En base de datos y conectado!<br>";
	echo $onlinerow['user_id'];
	echo "<br>";
	echo $time;*/

} elseif ($count=="1") {
	
	mysql_query("UPDATE user_online SET time='$time' WHERE session = '{$onlinerow['user_id']}'");
	/*echo "Actualizado y conectado!<br>";
	echo $onlinerow['user_id'];
	echo "<br>";
	echo $time;*/

} else {
	echo "Error 1";
}

?>