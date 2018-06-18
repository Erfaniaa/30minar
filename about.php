<?php
session_start();
require_once('includes/common.php');
?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href='includes/style.css'>
	<link rel="shortcut icon" href='<?php echo "$favicon"; ?>' type="image/x-icon">
	<title>درباره ی ما</title>
</head>

<body>
	<div id="print">
	  <?php showHeader(); ?>
		<div class="boxes">
			<div class="right_menu">
				<?php showMenu(); ?>
		  </div>
		  <div class="posts">
		  	<div class="box">
			  	<div class="title">درباره ی سازندگان</div>
			  	<div class="contents">ما این سایت را ساخته ایم!</div>
		  	</div>
		  </div>
	  </div>
		<?php showFooter(); ?>	  
  </div>
</body>
</html>