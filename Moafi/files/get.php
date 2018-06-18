<?
if(!isset($_SESSION)){ session_start();} 

require_once('../../includes/IO.php');
require_once('../../includes/jcalendar.class.php');
$calendar = new jCalendar;
$today = $calendar->getdate();
$list = array();

class Student
{
	public $firstname='', $lastname='', $class='', $first='', $second='', $third='', $fourth='', $place='';
	function set($fname, $lname, $class, $first, $second, $third, $fourth, $place)
	{
		$this->firstname = $fname;
		$this->lastname = $lname;
		$this->class = $class;
		$this->first = $first;
		$this->second = $second;
		$this->third = $third;
		$this->fourth = $fourth;
		$this->place = $place;
	}
}

?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script language="javascript" src='../../includes/jquery-1.9.1.min.js'></script>
	<link rel="stylesheet" type="text/css" href="../../includes/style.css">
	<title>  لیست معافیت های  <?echo  $today["weekday"]?></title>
</head>

<script>
function printDoc()
{
	$( ".noprint" ).each(function( index )
	{
		this.hidden = true;
	});

	//$('td').css("color", "black");
	window.print();

	$( ".noprint" ).each(function( index )
	{
		this.hidden = false;
	});
	//$('td').css("color", "white");
}
</script>
<body id="body">
<fieldset class = "fieldset">
<!--	<legend>  لیست معافیت های  <?echo  $today["weekday"]?></legend>  -->
<?
if  (!isset($_GET['grade']))
{
	global $rootDir;
	echo 	'<button class="orange_button" style=" height: 25px;" onclick="' . "window.location='?grade=1'". '">معافیت های پایه ی اول</button>';
	echo ' ';
	echo 	'<button class="orange_button" style=" height: 25px;" onclick="' . "window.location='?grade=2'". '">معافیت های پایه ی دوم</button>';
	echo ' ';
	echo '<a href="'.$rootDir.'"><button class="blue_button" style="height: 25px;">بازگشت به خانه</button></a>';
	echo	
		'<form style="float: left;" method="post" action="../../includes/IO.php">
			<input type="hidden" name="clear_moafi" value="true">
			<button class="red_button" style="height: 25px;">پاک کردن لیست معافیت ها</button>
		</form>';
}
else if (($_GET['grade'] == 1) or ($_GET['grade'] == 2))
{
	loadList();
	echo getTable();
	echo "<button id='printBut' onclick='printDoc()' class='noprint blue_button'>چاپ کردن</button>";
	echo " ";
	echo "<button onclick='".'window.location="get.php"'."' class='noprint red_button'>بازگشت</button>";
}
?>

</fieldset>
</body>
</html>

<?
function loadList()
{
	global $con, $list;
	$query="SELECT * FROM Moafi";
	$result = $con->query($query);
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$user = getUserData($row['username']);
		if ($user['class'][0] == $_GET['grade'])
		{
			$std = new Student();
			$std->set($user['firstname'], $user['lastname'], $user['class'], $row['first'], $row['second'], $row['third'], $row['fourth'], $row['place']);
			$list[] = $std;
		}
	}
	
	function cmp($a, $b)
	{
	    return strcmp($a->class, $b->class);
	}

	usort($list, "cmp");
}

function getTable()
{
	global $list, $lessons, $places;
	$table =  '<table align="center" border="1" id="listTable" style="font-family: B Nazanin, Nazanin, Ubuntu, Arial, Times New Roman; font-size: 20px; color: black;">';
	$table .= '<tr><td align="center">کلاس</td><td align="center">نام خانوادگی</td><td align="center">نام</td><td align="center">زنگ اول</td><td align="center">زنگ دوم</td><td align="center">زنگ سوم</td><td align="center">زنگ چهارم</td><td align="center">محل حضور</td><tr>';
	foreach ($list as $std)
	{
		$table .= '<tr height="32"><td align="center">'.$std->class.'</td><td align="center">'.$std->lastname.'</td><td align="center">'.$std->firstname.'</td><td align="center">'.$lessons[$std->first].'</td><td align="center">'.$lessons[$std->second].'</td><td align="center">'.$lessons[$std->third].'</td><td align="center">'.$lessons[$std->fourth].'</td><td align="center">'.$places[$std->place].'</td></tr>';
	}
	$table .= '</table>';
	return $table;
}

?>