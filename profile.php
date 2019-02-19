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

//variables

$edit="0";
//-----------upload image--------------
/*

if (isset($_POST['upload']))

// si hay un imagen en el campo subirlo
$maxwidth = "600"; // max width
$foto_dir = "avatar/"; // folder for images
$foto_name = $fotos_dir.time()."_".basename($_FILES['myfile']['name']); // file name with path
$foto_light_name = time()."_".basename($_FILES['myfile']['name']); // file name without path
$foto_tag = "<img src=\"$foto_name\" border=\"0\">"; // for adding in page
$foto_tag_preview = "<img src=\"$foto_name\" border=\"0\" width=\"$maxwidth\">"; // for preview

// mensajes de errores
$error_by_mysql = "<label class=\"label\">Error with add in data base</span>";
$error_by_file = "<label class=\"label\">Error with upload in folder, folder dostn exist</span>";


// inicio
if(isset($_FILES["myfile"]))
{
$myfile = $_FILES["myfile"]["tmp_name"];
$myfile_name = $_FILES["myfile"]["name"];
$myfile_size = $_FILES["myfile"]["size"];
$myfile_type = $_FILES["myfile"]["type"];
$error_flag = $_FILES["myfile"]["error"];

// si no hay errores
if($error_flag == 0)
{
$DOCUMENT_ROOT = $_SERVER['DOCMENT_ROOT'];
$upfile = getcwd()."/avatar/" . $userRow['username'].".".basename($myfile_type);
//$upfile = getcwd()."/img/" . basename($_FILES["myfile"]["name"]);
if ($_FILES['myfile']['tmp_name'])
{

//si no puese subir

if (!move_uploaded_file($_FILES['myfile']['tmp_name'], $upfile))
{
echo "$error_by_file";
exit;
}

}
else
{
    echo 'Have a problem, you are hacker. ';
    echo $_FILES['myfile']['name'];
    exit;
}

$type=basename($myfile_type);

//$q = "INSERT INTO 3_images (img) VALUES ('$foto_name')";
//$query = mysql_query($q);

$query = mysql_query("UPDATE users SET avatar = 'uploaded' WHERE username = '{$userRow['username']}'");
$query2 = mysql_query("UPDATE users SET avatar_type = '{$type}' WHERE username = '{$userRow['username']}'");

// los datos estan añadido en base datos correctamente
if ($query == 'true' && $query2 == 'true') {
?>
<!--<div class='text'>
<p>Image was uploaded UPI!</p><br><br>
<table>
<tr>
<td>
<a href='add_images_form.php' class='add_images'><div class='add_images_text'>Change image</div></a>
</td>
<td>
<a href='index.php' class='add_images'><div class='add_images_text'>Home</div></a>
</td>
</tr>
</table>
</div>-->
<?php
}

// si no estan 
else {
echo "$error_by_mysql";
}
}
elseif ($myfile_size == 0) {
?><!--<br><label class='label'>Not selected image!<br><br>
<a href='add_images_form.php' class='add_images'><div class='add_images_text'>Select image now</div></a>-->
<?php
}
}


*/
//-------------------------------------

if(isset($_POST['saveconfig']))
{
 $edit="0";
 
 if (!empty($_POST['name'])) {

	mysql_query("UPDATE users SET name = '' WHERE username = '{$userRow['username']}'");
 	mysql_query("UPDATE users SET name = '{$_POST['name']}' WHERE username = '{$userRow['username']}'");

 }

 if (!empty($_POST['lastname'])) {

	mysql_query("UPDATE users SET lastname = '' WHERE username = '{$userRow['username']}'");
	mysql_query("UPDATE users SET lastname = '{$_POST['lastname']}' WHERE username = '{$userRow['username']}'");

 }
 if (!empty($_POST['bio'])) {

	mysql_query("UPDATE users SET bio = '' WHERE username = '{$userRow['username']}'");
 	mysql_query("UPDATE users SET bio = '{$_POST['bio']}' WHERE username = '{$userRow['username']}'");
 }
 if (!empty($_POST['gender'])) {

	mysql_query("UPDATE users SET gender = '' WHERE username = '{$userRow['username']}'");
 	mysql_query("UPDATE users SET gender = '{$_POST['gender']}' WHERE username = '{$userRow['username']}'");

 }
 if ($_POST['country'] !== $userRow['country']) {

    mysql_query("UPDATE users SET country = '' WHERE username = '{$userRow['username']}'");
 	mysql_query("UPDATE users SET country = '{$_POST['country']}' WHERE username = '{$userRow['username']}'");
 	header("refresh:0;");

 }
 if (!empty($_POST['private'])) {

	mysql_query("UPDATE users SET private = '' WHERE username = '{$userRow['username']}'");
 	mysql_query("UPDATE users SET private = '{$_POST['private']}' WHERE username = '{$userRow['username']}'");

 } else {

	mysql_query("UPDATE users SET private = '' WHERE username = '{$userRow['username']}'");
 	mysql_query("UPDATE users SET private = 'FALSE' WHERE username = '{$userRow['username']}'");
 }

}

// include 'editprofileinfo.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $lang['PROFILE_TITLE']; ?>
		    		<?php

		    	 if (empty($userRow['name'])) {
		    	 	
		    	 	echo $userRow['username'];
		    	 	
		    	 } else {
		    	 
		    	 	echo $userRow['name'];
		    	 
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
			  <?php include 'avatar.php' ?>
			</div>
			
			<div class="userinfo">
			
			<form method="post" name="ProfileForm">
			  <div class="nameline">
				<h2 class="pg-name">
					<?php
						if (empty($userRow['name'])) {
							?><input type="text" name="name" placeholder="<?php echo $lang['YOURNAME']; ?>"/><?php
						} else {
							if (isset($_POST['edit'])) {
								
								?><span class="label"><?php echo $lang['NAME']; ?>: </span><input type="text" name="name" placeholder="<?php echo $lang['YOURNAME']; ?>" value="<?php echo $userRow['name']?>"/><?php

								
								} else {
								echo $userRow['name'];
							}
						}
						
					?>
				</h2>
				<h2 class="pg-name">
					<?php
						if (empty($userRow['lastname'])) {
							?><input type="text" name="lastname" placeholder="<?php echo $lang['YOURLASTNAME']; ?>"/><?php
						} else {
							if (isset($_POST['edit'])) {
								
								?><span class="label"><?php echo $lang['LASTNAME']; ?>: </span><input type="text" name="lastname" placeholder="<?php echo $lang['YOURLASTNAME']; ?>" value="<?php echo $userRow['lastname']?>"/><?php
								
								} else {
								echo $userRow['lastname'];
							}						
						}
						
					?>
				</h2>
				<div class="privateusr">
					<?php
					if ($userRow['private'] == 'FALSE') {
						//not display
					} else {
						?><i class="fa fa-lock"></i><?php
					}
					?>
				</div>
				<div class="usrconn">
					<? include 'user_online.php'; ?>
				</div>
				<p><span class="label"><?php echo $lang['USERNAME']; ?>:</span> <?php echo $userRow['username'];?></p>
				<p><span class="label"><?php echo $lang['EMAIL']; ?>:</span> <?php echo $userRow['email'];?></p>
				<p><span class="label"><?php echo $lang['ABOUTME']; ?>:</span>
					<?php
						if (empty($userRow['bio'])) {
							?><input type="text" name="bio" placeholder="<?php echo $lang['WRITESOMETHING']; ?>"/><?php
						} else {
							if (isset($_POST['edit'])) {
								
								?><input type="text" name="bio" placeholder="<?php echo $lang['WRITESOMETHING']; ?>" value="<?php echo $userRow['bio']?>"/><?php
								
								} else {
								echo $userRow['bio'];
							}						
						}
						
					?>
				</p>
				<p><span class="label"><?php echo $lang['GENDER']; ?>:</span>
					<?php
						if (empty($userRow['gender'])) {
							?><input type="radio" name="gender" value="male"> <?php echo $lang['MALE']; ?>
							<input type="radio" name="gender" value="female"> <?php echo $lang['FEMALE']; ?><?php
						} else {
							if (isset($_POST['edit'])) {
								
								if ($userRow['gender'] == "male") {
									?><input type="radio" name="gender" value="male" checked> <?php echo $lang['MALE']; ?>
									<input type="radio" name="gender" value="female"> <?php echo $lang['FEMALE']; ?><?php

								}
								
								if ($userRow['gender'] == "female") {
								
								?><input type="radio" name="gender" value="male"> <?php echo $lang['MALE']; ?>
								<input type="radio" name="gender" value="female" checked> <?php echo $lang['FEMALE']; ?><?php
								
								}
							} else {
							
								if ($userRow['gender'] == "male") {
								
									?> <i class="fa fa-mars"></i><?php
									
								} elseif ($userRow['gender'] == "female") {
								
									?> <i class="fa fa-venus"></i><?php
									
								} else {
								
								}
							}
						}					
						
						
					?></p>
				<p><span class="label"><?php echo $lang['JOINDATE']; ?>:</span> <?php echo $userRow['joindate'];?></p>
				<p><span class="label"><?php echo $lang['COUNTRY']; ?>:</span>
					<?php
						if (empty($userRow['country'])) {
							?>
							<select name="country">
								 <option value=""> <?php echo $lang['SELECTOPT']; ?></option>
								 <option value="EN"><?php echo $lang['ENLANG']; ?></option> 
								 <option value="ES"><?php echo $lang['ESLANG']; ?></option> 
								 <option value="CAT"><?php echo $lang['CATLANG']; ?></option>
								 <option value="RU"><?php echo $lang['RULANG']; ?></option> 
							</select><?php
						} else {
							if (isset($_POST['edit'])) {
								
								if ($userRow['country'] == "ES") {
									?>
									<select name="country">
										 <option value="ES"><?php echo $lang['ESLANG']; ?></option> 
										 <option value="EN"><?php echo $lang['ENLANG']; ?></option>
										 <option value="CAT"><?php echo $lang['CATLANG']; ?></option>
										 <option value="RU"><?php echo $lang['RULANG']; ?></option>
									</select><?php
								}
								
								if ($userRow['country'] == "EN") {
								
								?>
								<select name="country">
									 <option value="EN"><?php echo $lang['ENLANG']; ?></option> 
									 <option value="ES"><?php echo $lang['ESLANG']; ?></option> 
									 <option value="CAT"><?php echo $lang['CATLANG']; ?></option>
									 <option value="RU"><?php echo $lang['RULANG']; ?></option> 
								</select><?php
								}
								
								if ($userRow['country'] == "CAT") {
								
								?>
								<select name="country">
									 <option value="CAT"><?php echo $lang['CATLANG']; ?></option>
									 <option value="EN"><?php echo $lang['ENLANG']; ?></option> 
									 <option value="ES"><?php echo $lang['ESLANG']; ?></option>
									 <option value="RU"><?php echo $lang['RULANG']; ?></option> 
								</select><?php
								}

								if ($userRow['country'] == "RU") {
								
								?>
								<select name="country">
									 <option value="RU"><?php echo $lang['RULANG']; ?></option> 
									 <option value="CAT"><?php echo $lang['CATLANG']; ?></option>
									 <option value="EN"><?php echo $lang['ENLANG']; ?></option> 
									 <option value="ES"><?php echo $lang['ESLANG']; ?></option>
								</select><?php
								}
								
							} else {
									if ($userRow['country'] == "ES") {
										echo $lang['ESLANG'];
									}
									if ($userRow['country'] == "EN") {
										echo $lang['ENLANG'];
									}
									if ($userRow['country'] == "CAT") {
										echo $lang['CATLANG'];
									}
									if ($userRow['country'] == "RU") {
										echo $lang['RULANG'];
									}
								}
							}	
							?>

						</p>
						<?php
						
						if (isset($_POST['edit'])) {
							
							$edit = "1";
							
						}else {
							$edit = "0";
						}
						?>
							<p>
								<?php
								if (isset($_POST['edit'])) {
									
									if ($userRow['private'] == 'FALSE') {
										?><span class="label"><?php echo $lang['PRIVATE']; ?>: </span><input type="checkbox" name="private" value="TRUE"><i class="fa fa-unlock"></i><?php
									} else {
										?><span class="label"><?php echo $lang['PRIVATE']; ?>: </span><input type="checkbox" name="private" value="TRUE" checked><i class="fa fa-lock"></i><?php
									}
									

								} else {
									//Not display
								}
								
								?>
								</p>
							<!--<p><span class="label"><?php echo $lang['PASSWORD']; ?>: </span> ****</p>-->

				<button type="submit" class="bttn" name="saveconfig" onclick="submitForm();"><i class="fa fa-floppy-o"></i> <?php echo $lang['SAVE']; ?></button>
				<button type="submit" class="bttn" name="edit"><i class="fa fa-pencil-square-o"></i> <?php echo $lang['EDIT']; ?></button>
				</form>
				
			
				<?php
				$edit;
				if (empty($userRow['avatar']) && $edit == "1") {
					
					//include 'avatar.php';
					?><div class="edit-up-img">
					<iframe src="/upload.php" width="800" height="200" frameborder="0">Error</iframe>
					</div><?php
					 /*?>
					<form name='form' enctype='multipart/form-data' method='post'>
						<p>
						<label class='label'><?php echo $lang['SELECTIMG']; ?></label><br>
						<input type='file' name='myfile' id='myfile' class='input'/>
						</p>
						<br>
						<p>
					
						<button type='image' value='upload' title='upload'><?php echo $lang['UPLOAD']; ?></button>
					
						</p>
					</form>
					
					
					<?php*/
					
				}
				if (empty($userRow['avatar']) && $edit == "0") {
						
						//include 'avatar.php'; 
			
				}
				if (!empty($userRow['avatar']) && $edit == "1") {
						
						//include 'avatar.php'; 
						?><div class="edit-up-img">
					<iframe src="/upload.php" width="800" height="200" frameborder="0">Error</iframe>
					</div><?php
					 /*?>
						/*?>
						<form name='form' enctype='multipart/form-data' method='post'>
							<p>
							<label class='label'><?php echo $lang['SELECTIMG']; ?></label><br>
							<input type='file' name='myfile' id='myfile' class='input'/>
							</p>
							<br>
							<p>
						
							<button type='image' value='upload' title='upload'><?php echo $lang['UPLOAD']; ?></button>
						
							</p>
						</form>
						</div>
						<?php*/
						
					}
					if (!empty($userRow['avatar']) && $edit == "0") {
							
							//include 'avatar.php'; 
				
					}
				?>
			</div><!---#userinfo-->
		</div><!--#profilecontent-->
	
		</div><!--#content wrpr-->
		
		<div class="profileuserblog">
			<?php include 'blog_profile.php'; ?>
		</div><!--#profileuserblog-->
		
	</body>
</html>