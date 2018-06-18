<?
if(!isset($_SESSION)){ session_start();} 

require_once('common.php');

if (isset($_POST['clear_moafi']) && $_POST['clear_moafi'] == 'true')
{
	clearMoafi();
	echo '<script>window.location="../Moafi/files/get.php"</script>';
}
else if (isset($_POST['edit_user']) && $_POST['edit_user'] == 'true')
{
	setProfileData();
	echo '<script>window.location="../user/user.php"</script>';
}
else if (isset($_POST['updateForm']) && $_POST['updateForm'] == 'true' && isset($_POST['propID']))
{
	setProposalData($_POST['propID']);
	echo '<script>window.location="../Proposal/proposal.php"</script>';
}
else if (isset($_POST['delete_proposal']) && $_POST['delete_proposal'] == 'true')
{
	deleteProposal();
	echo '<script>window.location="../user/user.php"</script>';
}

function getProposalData($propID)
{
	if (isset($propID) && !isset($propID))
	{
		global $rootDir;
		echo '<script>window.location="'.$rootDir.'"/index.php"</script>';
	}
	global $con;
	$query="SELECT * FROM proposals WHERE ID = '".$propID."'";
	$result = $con->query($query);
	$proposal = array();
	if ($result->num_rows == 0) return 0;
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$proposal = $row;
		break;
	}
	$result->close();
	$proposal['username1'] = getUserData($proposal['username1']);
	$proposal['username2'] = getUserData($proposal['username2']);
	$proposal['username3'] = getUserData($proposal['username3']);
	$proposal['username4'] = getUserData($proposal['username4']);
	
	$proposal['teacher1'] = getUserData($proposal['teacher1']);
	$proposal['teacher2'] = getUserData($proposal['teacher2']);
	
	$startDate = explode('-', $proposal['starttime']);
	$proposal['startDay'] = $startDate[2];
	$proposal['startMonth'] = $startDate[1];
	$proposal['startYear'] = $startDate[0];
 	$endDate = explode('-', $proposal['endtime']);
	$proposal['endDay'] = $endDate[2];
	$proposal['endMonth'] = $endDate[1];
	$proposal['endYear'] = $endDate[0];
	$_SESSION['propID'] = $propID;
	return $proposal;
}

function getUserData($username)
{
	global $con;
	$query = 'SELECT * FROM users WHERE username = "' . $username . '"' ;
	$result = $con->query($query);
	$user = array();
	if ($username == '')
	{
		$user['username'] = '';
		$user['firstname'] = '';
		$user['lastname'] = '';
	}
	else if ($result->num_rows != 1) return false;
	else
	{
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
			if ($username != $row['username'])  break;
			global $userData;
			foreach ($userData as $k)
			{
					$user[$k] = $row[$k];
			}
			$user['userID'] = $row['ID'];	
		}
	}
	$result->close();
	return $user;
}

function clearMoafi()
{
	global $con;
	$query = "TRUNCATE Moafi";
	$stmt = $con->prepare($query);
	$stmt->execute();
	$stmt->close();
}		

function setProposalData($propID)
{
	if ($_POST['projectTitle']=="") $_POST['projectTitle'] = 'طرح بی عنوان - ' . $_SESSION['username'];
	if ($_POST['projectDesigner1']=="" && $_POST['projectDesigner2']=="" && $_POST['projectDesigner1']=="" && $_POST['projectDesigner2']=="") $_POST['projectDesigner1'] = $_SESSION['username'];
	$startDateArray = array($_POST['startYear'], $_POST['startMonth'], $_POST['startDay']);
	$startDate = implode('-', $startDateArray);
	$finishDateArray = array($_POST['finishYear'], $_POST['finishMonth'], $_POST['finishDay']);
	$finishDate = implode('-', $finishDateArray);
	global $con;
	$query = "UPDATE proposals SET title = ? , username1 = ?, username2 = ?, username3=?, username4=?, category=?, teacher1=?, teacher2=?, preface=?, problem=?, solutions=?, oursolution=?, benefits=?, goals=?, usages=?, needs=?, starttime=?, endtime=?,  othercomments=?, conclusion=? 	WHERE ID = ?";
	$stmt = $con->prepare($query);
	$stmt->bind_param('ssssssssssssssssssssi', $_POST['projectTitle'], $_POST['projectDesigner1'], $_POST['projectDesigner2'], $_POST['projectDesigner3'], $_POST['projectDesigner4'], $_POST['group'], $_POST['projectLeader1'], $_POST['projectLeader2'], $_POST['preface'], $_POST['problem'], $_POST['solutions'], $_POST['ourSolution'], $_POST['benefits'], $_POST['goals'], $_POST['usages'], $_POST['needs'], $startDate, $finishDate, $_POST['comments'], $_POST['conclusion'], $propID);
	$stmt->execute();
	$stmt->close();
}

function deleteProposal()
{
	global $con;
	$query = "DELETE FROM proposals WHERE ID = ?";
	$stmt = $con->prepare($query);
	$stmt->bind_param('i', $_SESSION['propID']);
	$stmt->execute();
	$stmt->close();
}

function setProfileData()
{
	if ($_POST['first_name'] == "" || $_POST['last_name'] == "")
		return;
	$_SESSION['firstname'] = $_POST['first_name'];
	$_SESSION['lastname'] = $_POST['last_name'];
	$_SESSION['class'] = $_POST['class'];
	$_SESSION['email'] = $_POST['email'];
	global $con;
	if ($_POST['password'] != "")
	{
		$query = "UPDATE users SET firstname=?, lastname=?, class=?, email=?, password=? WHERE username=?";
		$stmt = $con->prepare($query);
		$stmt->bind_param('ssssss', $_POST['first_name'], $_POST['last_name'], $_POST['class'], $_POST['email'], $_POST['password'], $_POST['username']);
		echo "<script>alert('رمز عبور شما با موفقیت تغییر یافت.');</script>";
	}
	else
	{
		$query = "UPDATE users SET firstname=?, lastname=?, class=?, email=? WHERE username=?";
		$stmt = $con->prepare($query);
		$stmt->bind_param('sssss', $_POST['first_name'], $_POST['last_name'], $_POST['class'], $_POST['email'], $_POST['username']);
	}
	$stmt->execute();
	$stmt->close();
}

function getProposalIDs($user)
{
	global $con;
	$query="SELECT * FROM proposals WHERE username1='".$user."' OR username2='".$user."' OR username3='".$user."' OR username4='".$user."' OR teacher1='".$user ."' OR teacher2='".$user."'";
	$result = $con->query($query);
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '<button type="button" id="proposal_link" class="proposal_link" value="'.$row['ID'].'">'.$row['title'].'</button> ';
	}
}

function newProposal()
{
	global $con;
	$query = "INSERT INTO proposals (title, username1) VALUES ('طرح بی عنوان - ".$_SESSION['username']."' , '" . $_SESSION['username'] . "')";
	$con->query($query);
	$query = "SELECT * FROM proposals WHERE title = 'طرح بی عنوان - ".$_SESSION['username']."' AND username1 = '".  $_SESSION['username'] ."'";
	$result = $con->query($query);
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$id = $row['ID'];
		$result->close();
		break;
	}
	return $id;
}

function searchProposals()
{
}


?>
