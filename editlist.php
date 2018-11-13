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
		$errormessage = "List not found!";

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$list = "";
		foreach($_POST['list'] as $element) {
			if($list == "")
				$list = $element;
			else $list = $list . "," . $element;
		}
		$title = $_POST['title'];

		$SQL = $db_found->prepare('UPDATE LISTS SET TITLE = ?, LIST = ? WHERE ID = ?');
			$SQL->bind_param('sss', $title, $list, $id);
			$SQL->execute();
				header ("Location: mylists.php");
	}
	?>

	<html>
	<head>
		<title>List Edit</title>
	</head>
	<body>
		<?PHP
		$row = mysqli_fetch_assoc($result);
		$items = explode(",", $row['LIST']);
		print "<form name =\"editform\" method =\"post\" action=\"editlist.php?list=" . $id . "\">";
		print "<input type = 'text' name =\"title\" value=\"" . $row['TITLE'] . "\"><br>";
		foreach($items as $item) 
			print "<input type = 'text' name=\"list[]\" value=\"" . $item . "\"><br>";
		?>
		<input type = "Submit" Name = "savebutton" Value = "Save">
	  </form>
	  <a href="mylists.php">My Lists</a>
		<p>
			<?PHP
			print $errormessage;
			?>
		</p>
	</body>
	</html>
