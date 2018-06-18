<?php
if(!isset($user)){ session_start();} 
require_once('action.php');
require_once('../includes/IO.php');


if (isset($_POST['logout']))
{
	logout();
	header( 'Location: login.php' );
}

$user = array();
if (isset($_GET['act']) && isset($_GET['uid']) && $_GET['act']=='view')
{
	$user = getUserData($_GET['uid']);
	if ($user == false)
	{
		header( 'Location: '.$rootDir );
	}
	else 
	{
		$isOwner = (isset($_SESSION['loggedin']) and $_SESSION['loggedin'] and $_SESSION['username'] == $user['username']);
	}
}
else if (!isset($_SESSION['loggedin']) || ($_SESSION['loggedin'] == false))
{	
	header( 'Location: login.php' );
}
else
{
	$user = $_SESSION;
	$isOwner = true;
}
clearstatcache();

?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href='../includes/style.css'>
	<link rel="shortcut icon" href='<?php echo "$favicon"; ?>' type="image/x-icon">
	<script language='javascript' src='../includes/jquery-1.9.1.min.js'></script>
	<script language='javascript' src='../includes/script.js'></script>
	<title>مشاهده ی نمایه</title>
</head>

<body>
	<div id="print">
	  <?php showHeader(); ?>
		<div class="boxes">
			<div class="right_menu">
				<?php showMenu(); ?>
				<?
					if ($isOwner)
						echo
							'<div class="box">
								<center>								
									<p>لطفا در اولین بار مشاهده ی نمایه ی خود نام و نام خانوادگی تان را به صورت فارسی وارد نمایید.</p>
								</center>
							</div>';
				?>
		  </div>
		  <div class="posts">
		  	<div class="box">
		  		<div class="title">نمایه ی <?  echo  $user['firstname'].' '.$user['lastname'] .' ('. (($user['isteacher'])?'استاد راهنما':'دانش آموز').')';  ?></div>
					<table class="profile_avatar">
						<tr>					
							<td><img id="avatar" src='avatars/<?php echo $user['username']; ?>.jpg' onerror="fixImage(id)"></td>
						</tr>
						<tr>					
							<td>
								<form action="upload.php" method="post" enctype="multipart/form-data">
									<input type="file" name="file" id="file" style="display: none;">								
									<input type="submit" id="change_pic" style="display: none;">								
								</form>
								<?
									if ($isOwner)								
										echo "<button id='browse_file' class='orange_button'>تغییر تصویر</button>";
								?>
							</td>
						</tr>
					</table>
				  <div class="contents">
				  	<form action="../includes/IO.php" method="post">
				  		<input type="hidden" value='true' name="edit_user">
				  		<text style="font-size: 17px; font-family: Titr;">اطلاعات شخصی:</text>
					  	<table class="profile">
						  	<tr>
						  		<td width="70">نام: </td>
						  		<td><textarea <? if (! $isOwner) echo "readonly "; ?> name="first_name" class="profile_editable"><? echo $user['firstname']?></textarea></td>
						  	</tr>
						  	<tr>
						  		<td>نام خانوادگی: </td>
						  		<td><textarea <? if (! $isOwner) echo "readonly "; ?> name="last_name" class="profile_editable"><? echo $user['lastname']?></textarea></td>
						  	</tr>
						  	<tr>
						  		<td>کد ملی: </td>
						  		<td><textarea readonly name="username" class="profile_editable"><? echo $user['username']?></textarea></td>
						  	</tr>
						  	<tr>
						  		<td>کلاس: </td>
						  		<td><textarea <? if (! $isOwner) echo "readonly "; ?> name="class" class="profile_editable"><? echo $user['class']?></textarea></td>
						  	</tr>
						  	<tr>
						  		<td>رایانامه: </td>
						  		<td><textarea <? if (! $isOwner) echo "readonly "; ?> name="email" class="profile_editable"><? echo $user['email']?></textarea></td>
						  	</tr>						  	
								<?
									if ($isOwner)
										echo						  	
									  	'<tr>
									  		<td>رمز عبور جدید: </td>
									  		<td><input type="password" name="password" class="profile_editable" value=""></td>
									  	</tr>';
						  	?>
					  	</table>
							<?
									if ($isOwner)					  	
					  				echo '<button class="green_button">ذخیره ی ویرایش ها</button>';
					  	?>
					  </form>
					  <br><text style="font-size: 17px; font-family: Titr;">پروژه های ثبت شده:</text><br>
						<form action='../Proposal/proposal.php' method="POST" id="propsalIDForm">
							<input type="hidden" name="proposalID" id="proposalID" value="new">
							<? getProposalIDs($user['username']); ?>
							<br>						
							<?
									if ($isOwner)
										echo '<button id="new_proposal" class="blue_button" value="new">ثبت پروپوزال جدید</button>';	
							?>
						</form>
							<form method="post" style="float: left;">
								<input type="hidden" name="logout">
								<?
									if ($isOwner)
										echo '<button class="red_button">خروج از سامانه</button>';
								?>
							</form>
							<br>
							<br>
				  </div>
		  	</div>
		  </div>
	  </div>
	<?php showFooter(); ?>	  
  </div>
</body>
</html>