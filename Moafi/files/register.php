<?
if(!isset($_SESSION)){ session_start();} 
require_once('../../includes/common.php');
if (!isset($_SESSION['loggedin']) || ($_SESSION['loggedin'] == false))
{	
	header( 'Location: '.$rootDir.'/user/login.php' );
}


global $con;
if(!isset($_POST['request']))
{
		die('<script> window.location= "../main.php" </script>');
}

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>سامانه ی درخواست معافیت</title>
    <link rel="stylesheet" type="text/css" href="../../includes/style.css">
</head>
<body>
<?php


//$_SESSION['username'] = '0440613574';

if ($_POST["request"]=="register")
{

	$place = $_POST["place"];	
	$place = preg_replace('/\s+/', '', $place);
	
	$reserved = $_POST['schedule'];
	for ($i=0; $i<4; $i++)
	{
		$reserved[$i] = preg_replace('/\s+/', '', $reserved[$i]);
		if ((!in_array($lessons[$reserved[$i]], $lessons)) or (in_array($reserved[$i], $forbiddenLessons)))
		{
			error("کلاس زنگ ".($i+1)." مجاز نیست.");
			return;
		}
	}
	if (!in_array($places[$place], $places))
	{
		error("محل مورد نظر یافت نشد.");
		return;
	}
	

	$time = date_timestamp_get(date_create());

	if (strlen($_SESSION['username']['class']) == 3)
	{
		echo '<script> alert("شما در قسمت نمایه ی خود شماره ی کلاستان را به درستی مشخص نکرده اید."); window.location="../main.php"; </script>';
		return;
	}
	$query = "INSERT INTO Moafi (username, first, second, third, fourth, place, time) VALUES (?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE first=?, second=?, third=?, fourth=?, place=?, time=?";
	$stmt = $con->prepare($query);
	$stmt->bind_param('ssssssisssssi', $_SESSION['username'],  $reserved[0],$reserved[1],$reserved[2], $reserved[3],$place, $time, $reserved[0],$reserved[1],$reserved[2], $reserved[3],$place, $time);
	$stmt->execute();
	$stmt->store_result();
	$stmt->close();

	echo '<script> alert("نام شما برای دریافت معافی در سیستم ثبت شد."); window.location="../main.php"; </script>';
	return;
}

function error($msg)
{
	echo "";
	echo '<script> alert("' . $msg . '") </script>' ;
	die('<script> window.location= "main.php" </script>');
}
?>		
</body>
</html>