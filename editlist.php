<?PHP
$errormessage = "";
$id = $_GET["list"];
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location: login.php");
}

	require '../../configure.php';
	$database = "lists";

	$db_found = new mysqli(DB_SERVER, DB_USER, DB_PASS, $database);

	if ($db_found) {		
	
			$SQL = $db_found->prepare('SELECT TITLE, LIST FROM LISTS WHERE ID = ?');
			$SQL->bind_param('s', $id);
			$SQL->execute();
			$result = $SQL->get_result();
			
		}
	
	else {
		$errormessage = "Database Not Found";
	}

	if($result->num_rows < 1)
		$errormessage = "List not found!"

	?>

	<html>
	<head>
		<title>List Edit</title>
	</head>
	<body>
		<?PHP
		$row = mysqli_fetch_assoc($result);
		$items = explode(",", $row['LIST']);
		print "<form name =\"editform\" method =\"post\" action=\"editlist.php\">";
		print "<input type = 'text' name = 'title' value=\"" . $row['TITLE'] . "\"><br>";
		foreach($items as $item) 
			print "<input type = 'text' name = 'list[]' value=\"" . $item . "\"><br>";
		?>
		<input type = "Submit" Name = "savebutton" Value = "Save">
	  </form>
		<p>
			<?PHP
			print $errormessage;
			?>
		</p>
	</body>
	</html>
