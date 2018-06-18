<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href='../includes/style.css'>
	<link rel="shortcut icon" href='<?php echo "$favicon"; ?>' type="image/x-icon">
</head>

<?
	if(!isset($_SESSION)){ session_start();} 
	require_once('../includes/common.php');
	
	global $rootDir;
	$exp = explode(".", $_FILES['file']['name']);
	$ext = strtolower(end($exp));
	if (($ext == "jpg" || $ext == "jpeg" || $ext == "png" || $ext == "gif") && $_FILES['file']['size'] / 1024 <= 500)
		move_uploaded_file($_FILES['file']['tmp_name'], "avatars/".$_SESSION['username'].".jpg");
	else
		"<script>alert('فایل ارسالی باید عکسی با کم تر از ۵۰۰ کیلوبایت حجم باشد.');</script>";
	echo "<script>window.location='user.php'</script>"
?>

</html>