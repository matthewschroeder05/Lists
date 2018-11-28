<?PHP
$errormessage = "";
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location: login.php");
}

	require '../../configure.php';
	$database = "lists";

	$db_found = new mysqli(DB_SERVER, DB_USER, DB_PASS, $database);

	if ($db_found) {		
	
			$SQL = $db_found->prepare('SELECT ID, TITLE, LIST FROM LISTS WHERE L1 = ?');
			$SQL->bind_param('s', $_SESSION['user']);
			$SQL->execute();
			$result = $SQL->get_result();
			
		}
	
	else {
		$errormessage = "Database Not Found";
	}

?>
<html>
<head>
	<title>My Lists</title>
	<link rel="stylesheet" type="text/css" href="liststyle.css">
</head>
<body>
	<?PHP 

			while($row = mysqli_fetch_assoc($result)) {
				$items = explode(",", $row['LIST']);
				print $row['TITLE'] . " <a href=\"editlist.php?list=" . $row['ID'] . "\">edit</a><br>";
				$count = 0;
				foreach($items as $item) {
					($count % 2 == 0) ? print $item . "<br>" : print "<div class=\"mylisteven\">" . $item . "</div>";
					$count++;
				}
			}
			
	?>
	<p>
		<a href="newlist.php">new list</a> <a href="logout.php">log out</a>
		<p>
			<?PHP 
			print $errormessage;
			?>
</body>
</html>
