<?

if(!isset($_SESSION)){ session_start();} 
require_once('config.php');
//conDB();

importUsers();
function importUsers()
{
	global $con;
	$request = array();
	$query = "SELECT * FROM oldusers WHERE ((type=1 OR type=2) AND (unit <> 1390))  LIMIT 0, 30000";
	$result = $con->query($query);
	
	$request[] = "TRUNCATE TABLE  users";
	$request[] = 'INSERT INTO users (username)	VALUES ("NULL")';
	$request[] = 'INSERT INTO users (username, password, firstname, lastname, isteacher)	VALUES ("0440613574", "test", "Faraz", "Taheri", 0)';
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$request[] = 'INSERT INTO users (username, password, firstname, lastname, isteacher)	VALUES ("'.$row['username'].'", "'.$row['password'].'", "'.$row['name'].'", "'.$row['family'].'", "'. (($row['type']==1)?0:1) .'")';
	}
	print_r($request);
	$result->close();
	
	foreach ($request as $r)
	{
		$con->query($r);
	}
}

?>