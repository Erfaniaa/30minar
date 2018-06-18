<?php
if(!isset($_SESSION)){ session_start();} 

require_once('action.php');
$error = "";
if (isset($_SESSION['loggedin']) && ($_SESSION['loggedin'] == true))
{
	header( 'Location: user.php' );
}
if (isset($_POST['login']))
{
	if ($_POST['username'] == "")
	{
		$error = "نام کاربری را وارد کنید.";
	}
	else if ($_POST['password']=="")
	{
		$error = "رمز عبور را وارد کنید.";
	}
	else
	{
		(doLogin())?(header( 'Location: user.php' )):($error = "نام کاربری یا رمز عبور اشتباه است.");
	}	
}

?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href='../includes/style.css'>
	<link rel="shortcut icon" href='<?php echo "$favicon"; ?>' type="image/x-icon">
	<title>ورود</title>
</head>

<body>
	<div id="print">
	  <?php showHeader(); ?>
		<div class="boxes">
			<div class="right_menu">
				<?php showMenu(); ?>
				<div class="box">
						<center>								
							<p>نام کاربری تان همان کد ملی شما است.</p>
						</center>
				</div>
		 	</div>
		  <div class="posts">
		  	<div class="box">
			  	<div class="title">ورود به سیستم</div>
			  	<div class="contents">برای ورود به سامانه نام کاربری و رمز عبور خود را وارد کنید.<br>
						<form method="post" action="login.php">
							<input type="hidden" name="login">
							<table class="login">
								<tr>
									<td colspan="2"><?  echo $error; ?></td>
								</tr>
								<tr>
									<td>نام کاربری:</td>
									<td><input type="text" id="username" name="username"></td>
								</tr>
								<tr>	
									<td>رمز عبور:</td>
									<td><input type="password" id="password" name="password"></td>
								</tr>
								<tr>
									<th colspan="2"><button class="blue_button">ورود</button></th>
								</tr>
							</table>
						</form>
			  	</div>
		  	</div>
		  </div>
	  </div>
	<?php showFooter(); ?>	  
  </div>
</body>
</html>
