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

?><div class="avaprev"><?php
include 'avatar.php';
?></div><?php

//-----------upload image--------------

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

header("Location: upload.php");
echo $lang['IMG_SECCES'];


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



//-------------------------------------
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="style.css" type="text/css" />
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
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
</body>
</html>