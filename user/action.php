<?
if(!isset($_SESSION)){ session_start();} 
require_once('../includes/IO.php');


function doLogin()
{
	global $con;
	$ret = 0;
	$username = $_POST['username'];
	$password = $_POST['password'];
	$user = $username;

	$query="SELECT username FROM users WHERE username = ? AND password = ?";
	$stmt = $con->prepare($query);		
	$stmt->bind_param('ss', $username, $password);
	$stmt->execute();
	$stmt->bind_result($username);
	
	while ($stmt->fetch())
	{
		$stmt->close();	
		loadUser($user);
		return 1;
    }
    
    $stmt->close();	
	return 0;
}

function loadUser($username)
{
	$_SESSION = getUserData($username);
	$_SESSION['loggedin'] = true;
}

function logout()
{
	global $userData;
	$_SESSION['loggedin'] = false;
	unset($_SESSION['loggedin']);
	foreach ($userData as $k)
	{
		unset($_SESSION[$k]);
	}
	unset($_SESSION['userID']);
}


?>