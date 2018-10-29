<?PHP
$title = "";
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location: login.php");
}

//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require '../../configure.php';
	$database = "lists";

	$db_found = new mysqli(DB_SERVER, DB_USER, DB_PASS, $database);

	if ($db_found) {		
	
			$SQL = $db_found->prepare('SELECT TITLE, LIST FROM LISTS WHERE L1 = ?');
			$SQL->bind_param('s', $_SESSION['user']);
			$SQL->execute();
			$result = $SQL->get_result();
			
		}
	
	else {
		$errorMessage = "Database Not Found";
	}

?>
<html>
<head>
	<title>My Lists</title>
</head>
<body>
	<?PHP 

			while($row = mysqli_fetch_assoc($result)) {
				$items = explode(",", $row['LIST']);
				print $row['TITLE'] . "<br>";
				foreach($items as $item) 
					print $item . "<br>";
			}
			
	?>
	<p>
		<a href="page1.php">home</a> <a href="logout.php">log out</a>
</body>
</html>
