<?PHP
$errormessage = "";
$id = $_GET["list"];
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location: login.php");
}
$uname = $_SESSION['user'];
require "../../configure.php";
$database = "lists";
$db_found = new mysqli(DB_SERVER, DB_USER, DB_PASS, $database );
	if ($db_found) {
	$SQL = $db_found->prepare('SELECT * FROM lists WHERE L1 = ? AND ID = ?');
	$SQL->bind_param('ss', $uname, $id);
	$SQL->execute();
	$result = $SQL->get_result();
		if ($result->num_rows == 1) {
			$SQL = $db_found->prepare('DELETE FROM lists WHERE ID = ?');
			$SQL->bind_param('s', $id);
			$SQL->execute();
			header("Location: mylists.php");
		}
		else $errormessage = "You do not have permission to delete this list!";
	}
	else $errormessage = "Error: database not found!";
	?>
<html>
<head>
<title>delete list</title>
</head>
<body>
<?PHP print $errormessage ?>
</body>
</html>
