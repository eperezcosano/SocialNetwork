<?php
	$time=time();
	$time_check=$time - 60;
	$time_check2=$time  - 300;
	$select=mysql_query("SELECT * FROM user_online WHERE session = '{$row['user_id']}'");
	$user_online_row=mysql_fetch_array($select);

		//echo "Hora: " . $time . "<br>";
		//echo "Limite 1: " . $time_check . "<br>";
		//echo "Limite 2: " . $time_check2 . "<br>";
		//echo "Hora Usuario: " . $user_online_row['time'] . "<br>";

		//echo "Limite " . $time_check . "<br>";

		if (!isset($user_online_row['time'])) {
			?><img src='/img/offline2.png'></img><?php
		} else {
			if ($user_online_row['time'] > $time_check2) {

				if ($user_online_row['time'] > $time_check) {

					?><img src='/img/online.png'></img><?php

				} elseif ($user_online_row['time'] <= $time_check) {

					?><img src='/img/offline1.png'></img><?php
				}
				
			} elseif ($user_online_row['time'] <= $time_check2) {

				mysql_query("DELETE FROM user_online WHERE session = '{$row['user_id']}'");
				?><img src='/img/offline2.png'></img><?php

			} else {
				echo "Error 2";
			}

		}

?>