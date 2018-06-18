<?php

if(!isset($_SESSION)){ session_start();} 

$visitsTable = "Visits";
$rootDir = "http://localhost/helli";
#$rootDir = "http://e-alimohammadi.allamehelli.ir/helli";
$profPicsDir = $rootDir . '/user/avatars/';
$con = "";
conDB();

$userData =  array('username', 'password', 'firstname', 'lastname', 'persianFirst', 'persianLast', 'class', 'email', 'phone', 'mobile', 'parentsmobile', 'address', 'group1', 'group2', 'sgroup', 'isteacher', 'lastyearproject', 'lastyeargroup');


function conDB()
{
	global $con;
	#$DB = array("host"=>"localhost", "username"=>"0019899564", "password"=>"899564", "DB"=>"0019899564_db");
	$DB = array("host"=>"localhost", "username"=>"root", "password"=>"root", "DB"=>"hellidb");
	
	$con = mysqli_connect($DB['host'], $DB['username'], $DB['password'], $DB['DB']);
	if (mysqli_connect_errno())
	{
		die ("Failed to connect to MySQL: " . mysqli_connect_error());
	}
}


?>