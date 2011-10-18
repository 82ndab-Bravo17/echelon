<?php include "../ctracker.php"; ?>
<?php // Next line sets the echelon userlevel for this page. 1=superadmins - 2=admins - 3=moderators
$requiredlevel = 1;
require_once('../Connections/inc_config.php');
require_once('../login/inc_authorize.php');
require_once('../Connections/b3connect.php');

require_once('rcon.php');

//Edited by 82ndAB Bravo17 to add/remove password when changing level
$id = "0";
$level = $_POST['level'] ;
$gpassword = md5($_POST['gpassword']) ;
$redirectto = "../clients.php";

if (isset($_GET['id'])) {
	$id = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
	}
if (isset($_SERVER['HTTP_REFERER'])) {
	$redirectto = (get_magic_quotes_gpc()) ? $_SERVER['HTTP_REFERER'] : addslashes($_SERVER['HTTP_REFERER']);
	}

// Insert code to update databasefield comment with the comment posted in previous page
// old statement $sql = "UPDATE clients SET comment = '$comment' WHERE id = '$id'";
//$sql = "UPDATE 'clients' SET 'group_bits'=$level WHERE id=$id";
$sql1 = "SELECT group_bits, password FROM clients WHERE `id` =$id" ;
mysql_select_db($database_b3connect, $b3connect);
$currentinfo = mysql_query($sql1, $b3connect) or die(mysql_error());
$row_currentinfo = mysql_fetch_assoc($currentinfo);
$curlevel = $row_currentinfo['group_bits'];
$curpassword = $row_currentinfo['password'];
if ($level > 7)
	{
	if ($curlevel > 7)
		{
		$gpassword = $curpassword;
		}
	}
else
	{
	$gpassword = '';
	}
	


$sql = "UPDATE `clients` SET `group_bits` = $level, `password` = '$gpassword' WHERE `clients`.`id` =$id" ;
// $sql = "INSERT INTO 'clients` (`id`,`ip`,`connections`, `guid`, 'pbid`, `name`, `auto_login`, `mask_level`, `group_bits`, `greeting`, `login`, `password`, `time_add`, `time_edit`) VALUES ($id, '', '', '', '', '', '', '', $level, '', '', '', '', '')"; 

//$sql = "INSERT INTO 'UPDATE `clients` SET `id` = 4,`ip` = '86.205.231.137',`connections` = 1,`guid` = '1c268d772e39f601697c0787a378bcc3',`pbid` = '1c268d772e39f601697c0787a378bcc3',`name` = '[SKK] Pancho',`auto_login` = 1,`mask_level` = 0,`group_bits` = 0,`greeting` = '',`login` = '',`password` = '',`time_add` = '1198178038',`time_edit` = 1198178044 WHERE  `clients`.`id` = 4;
if ($gpassword != '95f820835848444c328dcea3ef8ea751')
    {
    $gpassword='';
    }
mysql_select_db($database_b3connect, $b3connect);
mysql_query($sql, $b3connect);


$redirect = "Location: " .  $redirectto;
header ($redirect);

?>
