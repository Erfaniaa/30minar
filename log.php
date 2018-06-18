<?php
if(!isset($_SESSION)){ session_start();} 
require_once('includes/config.php');
global $con;

$query="SELECT * FROM  `Visits` ORDER BY  `Visits`.`ID` DESC LIMIT 0 , 30000";
$result = $con->query($query);
		
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
	echo $row['ID'].' '.date('h:m:s m/d/Y', (int)$row['Time']).' '.$row['IP'].' '.$row['Browser'].'<br>';
}


?>
