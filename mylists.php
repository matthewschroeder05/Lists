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
	<script src="lists.js"></script>
	<link rel="stylesheet" type="text/css" href="liststyle.css">
</head>
<body>
	<div class="main-container">
	<?PHP 

			while($row = mysqli_fetch_assoc($result)) {
				print "<div class=\"list-container\">";
				$items = explode(",", $row['LIST']);
				print "<div class=\"listtitle\">" . $row['TITLE'] . "<div class=\"title\"><a href=\"editlist.php?list=" . $row['ID'] . "\">edit</a> <a href=\"deletelist.php?list=" . $row['ID'] . "\">delete</a></div></div><br>";
				$count = 0;
				foreach($items as $item) {
					($count % 2 != 0) ? print "<div class=\"listitem\">" . $item . "</div>" : print "<div class=\"mylisteven\">" . $item . "</div>";
					$count++;
				}
				print "</div>";
			}
			
	?>
	<p>
		<a href="newlist.php">new list</a> <a href="logout.php">log out</a>
		<p>
			<?PHP 
			print $errormessage;
			?>
		</p>
	</p>
</div>
</body>
</html>
