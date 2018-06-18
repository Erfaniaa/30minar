<? 
	if(!isset($_SESSION)){ session_start();} 
	require_once('../includes/common.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>404 - Not Found! :(</title>
<style type='text/css'>
.style1 {
	color: #FFFFFF;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 18px;
}
.style4 {font-size: 12px}
a:link {
	color: #FF0000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
.style5 {color: #FF0000}

</style></head>
<body bgcolor='000000' text='#CCCCFF' vlink='#CCCCFF' alink='#CCCCFF'> 
<table width='100%' height='100%' border='0' cellpadding='0' cellspacing='0'> 
  <tr> 
    <td width='100%' height='100%' valign='middle' align='center'>
      <p><img src="404.gif" alt="404" width="254" height="261" /></a></p>
      <p class='style1'><span class='style5'>ERROR!</span><br> 
      <span class='style4'>Uh-oh. The page you are looking for is missing. It's possible you capitalized something that shouldn't be capitalized. If you think this error is from the server, please simply send me an email . Click <a href=<?  echo $rootDir;?> target='_self'>here</a> if you don't know what else to do. </span></p>
	</td>
  </tr>
</table>
<footer> <center>
You can also help to find lost people by clicking <a href="lostpeople.html">here</a>.
</center>
</footer> 
</body>
</html>