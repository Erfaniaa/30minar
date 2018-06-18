<?php

if(!isset($_SESSION)){ session_start();} 
require_once('config.php');

if (!isset($_SESSION['visited']))
{
	global $con;
	$query = "INSERT INTO Visits (Time, IP, Browser)	VALUES (?, ?, ?)";
	$stmt = $con->prepare($query);
	$stmt->bind_param('iss', $Time, $IP, $Browser);
	$Time = date_timestamp_get(date_create());
	$IP = $_SERVER['REMOTE_ADDR'];
	$Browser = $_SERVER['HTTP_USER_AGENT'];
	$stmt->execute();
	$stmt->close();
	$_SESSION['visited'] = true;
	$con->close();
}

$groups = array("Biology" => "زیست", "Physics" => "فیزیک", "Astronomy" => "نجوم", "Chemistry" => "شیمی", "Mechanics" => "مکانیک", "Aerospace" => "هوا و فضا", "Computer" => "کامپیوتر", "Electronic" => "الکترونیک", "Math" => "ریاضی", "Humanities" => "انسانی",  "Executive" => "اجرایی");

$places = array("BioLab" => "آزمایشگاه زیست",  "PhysicsLab" => "آزمایشگاه فیزیک" ,  "AstronomyLab" => "اتاق نجوم",  "ChemistryLab" => "آزمایشگاه شیمی" , "MechanicsLab" => "کارگاه مکانیک", "ComputerSite" => "سایت کامپیوتر",  "MathLab" => "اتاق ریاضی", "Library" => "کتابخانه", "SeminarRoom" => "اتاق سمینار");

$lessons = array("NULL" => "---", "Computer" => "کامپیوتر", "Physics" => "فیزیک", "Math" => "ریاضی", "Chemistry" => "شیمی", "Sport" => "ورزش", "Arabic" => "عربی" , "Geography" => "جغرافی", "English" => "زبان انگلیسی", "Religious" => "دینی",  "Geometry" => "هندسی", "Statistics" => "آمار",  "Literature" => "ادبیات", "Persian" => "زبان فارسی",  "Technics" => "تکنیک|آزمایشگاه",  "Sociology" => "اجتماعی", "Research" => "پژوهشی", "Biology" => "زیست شناسی|گیاهی|جانوری");

$forbiddenLessons = array("Math", "Physics", "Biology", "Geometry", "Chemistry", "Arabic");

$favicon = "favicon";

function showHeader()
{
	global $rootDir;	
	$headerLinks = array("خانه" => "$rootDir", "ورود" => "$rootDir/user/login.php", /*"پروژه ها" => "$rootDir/Projects/main.php",*/ "معافیت ها" => "$rootDir/Moafi/main.php");	
	echo "<div class='header'>";
	echo "<div class='transparent'>";
	echo "</div>";
	echo "<ul class='headerLinks'>";
	foreach ($headerLinks as $title => $location)
	{
		if ($title == "ورود" && isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true)
		{
			echo "<li class='headerLinks'><a href='$location'>نمایه ی کاربر</a></li>";
		}
		else
		{
			echo "<li class='headerLinks'><a href='$location'>$title</a></li>";
		}
	}
	echo "</ul>";
	echo "</div>";
}

function showFooter()
{
	echo "<div class='footer'>";
	echo "<div class='transparent'>";
	echo "</div>";
	echo "<div class='copyright'>";
	echo "<center>";
	echo "Created by <a href='http://ftaheri.allamehelli.ir'>Faraz Taheri</a> and <a href='http://opso.ir'>Erfan Alimohammadi</a><br>";
	echo "&#169; 2013 Allame Helli high school";
	echo "</center>";
	echo "</div>";
	echo "</div>";
}

function showMenu()
{
	global $rootDir;	
	$logo = "$rootDir/includes/images/Sampad.png";
	$description = "به سامانه ی امور پژوهشی ۳۰ امین سمینار علوم و فنون دبیرستان علامه حلی تهران خوش آمدید!";
	echo "<div class='box'>";  	
	echo "<center><img class='logo' src='$logo'></center>";
	echo "<div class='contents'><center>$description</center></div>";
	echo "</div>";
	/*echo "<div class='box'>";
	echo "<div class='title'>سلام</div>";
	echo "<div class='contents'>این یک تست است. نظر شما چیست؟</div>";
	echo "</div>";*/
}


?>