<?
if(!isset($_SESSION)){ session_start();} 
require_once('../includes/common.php');
if (!isset($_SESSION['loggedin']) || ($_SESSION['loggedin'] == false))
{	
	header( 'Location: '.$rootDir.'/user/login.php' );
}

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href='../includes/style.css'>
		<link rel="shortcut icon" href='<?php echo "$favicon"; ?>' type="image/x-icon">
		<title>صفحه ی اصلی</title>
	</head>

<body>
	<div id="print">
	  <?php showHeader(); ?>
		<div class="boxes">
			<div class="right_menu">
				<?php showMenu(); ?>
				<?
					if ($_SESSION['isteacher'] == 1)
						echo
							'<div class="box">
								<center>
									<p>پس از بررسی روزانه ی لیست معافیت ها لیست باید خالی شود تا برای استفاده ی دانش آموزان از این سامانه آماده شده باشد.<br>
									<a href="files/get.php"><button class="blue_button" style="margin: 10px; width: 150px;">دریافت لیست معافیت ها</button></a></p>
								</center>
							</div>';
				?>					
		  </div>
		  
		  <div class="posts">
		  	<div class="box">
			  	<div class="title">نکات قابل توجه</div>
			  	<div class="contents">
			  		<ul>
							<li>معافیت هر روزی را باید روز قبل درخواست کنید.</li>
							<li> به دلیل جا به جایی زنگ ها، معافیت شما برای عنوان درس اعتبار دارد نه زنگ آن درس.</li>
							<li>درخواست شما به معنای دریافت معافیت نیست. حتما صبح روز بعد به لیست نهایی توجه کنید.</li>
							<li>در صورت بروز خطا در سیستم پس از چند دقیقه دوباره امتحان کنید.</li>
							<li>در صورت وجود اشکال در برنامه ی درسی و دیگر اطلاعات، حتما ما را مطلع کنید.</li>
							<li>بدیهی است در صورت سو استفاده از معافیت به شما معافیت تعلق نمیگیرد.</li>
						</ul>
			  	</div>
		  	</div>
		  	
		  	<div class="box">
			  	<div class="title">فرم درخواست معافیت</div>
			  	<div class="contents">
			  		<center>
							<form action="files/register.php" method="post">
								<table width="300" border="0" align="center">
							    <tr>
								    <td><label>زنگ اول</label></td>
								    <td><select  name="schedule[]" id="schedule1"><? foreach($lessons as $en => $fa){echo '<option value='.$en.'>'.$fa.'</option>';} ?></select></td>
								  </tr>
								  <tr>
								    <td><label>زنگ دوم</label></td>
								    <td><select  name="schedule[]" id="schedule2"><? foreach($lessons as $en => $fa){echo '<option value='.$en.'>'.$fa.'</option>';} ?></select></td>
								  </tr>
								  <tr>
								    <td><label>زنگ سوم</label></td>
								    <td><select  name="schedule[]" id="schedule3" ><? foreach($lessons as $en => $fa){echo '<option value='.$en.'>'.$fa.'</option>';} ?></select></td>
								  </tr>
								  <tr>
								    <td><label>زنگ چهارم</label></td>
								    <td><select  name="schedule[]" id="schedule4"><? foreach($lessons as $en => $fa){echo '<option value='.$en.'>'.$fa.'</option>';} ?></select></td>
								  </tr>
								  <tr>
								    <td><label>محل حضور</label></td>
								    <td><select name="place" id="place"><? foreach($places as $en => $fa){echo '<option value='.$en.'>'.$fa.'</option>';} ?></select></td>
								  </tr>
								</table>
							    <input type="hidden" name="request" value="register">
							    <button class="green_button" style="margin: 15px;">ثبت درخواست</button>
							</form>
						</center>
			  	</div>
		  	</div>
		  	
		  </div>
	  </div>
	<?php showFooter(); ?>	  
  </div>
</body>

</html>