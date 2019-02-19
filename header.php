</html>
		<div id="header">
		<div class="wrpr">
		    <div id="left">
		    	<h1><a href="/home.php"><i class="fa fa-empire"></i> Icaria</a></h1>
		    </div>
		    <div id="logout">
			<a href="/profile.php"> <?php include 'avatar.php';
		    	 ?></a>
		    	<a href="/profile.php"><i class="fa fa-user"></i> <?php
		    	 if (empty($userRow['name'])) {
		    	 	
		    	 	echo $userRow['username'];
		    	 	
		    	 } else {
		    	 
		    	 	echo $userRow['name'];
		    	 
		    	 }
		    	 ?></a>
		    	<a href="/users.php"><i class="fa fa-users"></i> <?php echo $lang['USERS']; ?></a>
		    	<a href="/conversations.php"><i class="fa fa-inbox"></i> <?php echo $lang['MESSAGES']; ?>
		    		<?php

		    		$get_con = mysql_query("SELECT `hash`, `user_one`, `user_two` FROM message_group WHERE user_one='{$userRow['user_id']}' OR user_two='{$userRow['user_id']}'");

						while ($run_con = mysql_fetch_array($get_con)) {
							
							$hash = $run_con['hash'];
							$user_one = $run_con['user_one'];
							$user_two = $run_con['user_two'];

							if ($user_one == $userRow['user_id']) {
								
								$select_id = $user_two;

							} else {
								
								$select_id = $user_one;

							}

							$user_get = mysql_query("SELECT * FROM users WHERE user_id='$select_id'");
							$run_user = mysql_fetch_array($user_get);
							$select_username = $run_user['username'];		

							$lastm=mysql_query("SELECT * FROM messages WHERE group_hash='$hash' ORDER BY id DESC");
							$lastm_row=mysql_fetch_array($lastm);

							$check_readed = $lastm_row['readed'];

							if ($lastm_row['from_id'] == $userRow['user_id']) {
								$deliver = $lang['YOU'];
								if ($check_readed == 0) {
									$icon = "<i class='fa fa-angle-right'></i>";
								} else {
									$icon = "<i class='fa fa-angle-double-right'></i>";
								}
							} elseif ($lastm_row['from_id'] == $run_user['user_id']) {
								$deliver = $select_username;
								if ($check_readed == 0) {
									$nonreaded_query = mysql_query("SELECT * FROM messages WHERE readed='0' AND group_hash='$hash'");
									$num_non_readed = mysql_num_rows($nonreaded_query);
									$icon = "<b>(" . $num_non_readed . ")</b>";
								} else {
									$icon = "<i class='fa fa-angle-double-left'></i>";
								}
							}

							$total += $num_non_readed;	
						}

						if ($total >= '1') {
							echo "<b>(" . $total . ")</b>";
						} else {
							//not display
						}
						
		    		?>
		    	</a>
				<a href="logout.php?logout"><?php echo $lang['SIGN_OUT']; ?> <i class="fa fa-sign-out"></i></a>
			</div>
		</div><!--#wrpr-->
		</div><!--#header-->
</html>