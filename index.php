<?php
if(!isset($_SESSION)){ session_start();} 
require_once('includes/common.php');
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href='includes/style.css'>
		<link rel="shortcut icon" href='<?php echo "$favicon"; ?>' type="image/x-icon">
		<title>صفحه ی اصلی</title>
	</head>

	<body>
		<div id="print">
		  <?php showHeader(); ?>
			<div class="boxes">
				<div class="right_menu">
					<?php showMenu(); ?>
			  </div>
			  <div class="posts">
			  	<!-- Start of Admin Post Box -->
			  	<div class="box">
				  	<div class="title">اجرای آزمایشی سامانه</div>
				  	<div class="contents">
					  	<ul>
						  	<li>سامانه ی ثبت پروپوزال پروژه ها به صورت آزمایشی فعال شده است.</li>
						  	<li>شما می توانید از طریق نمایه ی خود اقدام به ثبت طرح پروژه ی خود بکنید.</li>
								<li>لطفا نام و نام خانوادگی خود را به شکل فارسی در نمایه ی خود وارد نمایید.</li>
							</ul>
						</div> 
				  	<div class="info">
				  		<div class="right_aligned">مدیر</div>
				  		<!-- <div class="left_aligned">Post Rating</div> -->
				  		<div class="left_aligned">۱۷ تیر ۹۲</div>
				  	</div>
			  	</div>
			  	<!-- End of Admin Post Box -->
			  </div>
		  </div>
		<?php showFooter(); ?>	  
	  </div>
	</body>
</html>