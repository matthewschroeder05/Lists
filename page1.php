<?PHP
$errormessage = '';
$debug = "";

session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location: login.php");
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	require '../../configure.php';
	$title = trim($_POST['listname']);
	$list = trim($_POST['item']);
	$database = "lists";
	$db_found = new mysqli(DB_SERVER, DB_USER, DB_PASS, $database);
	if(!$title || !$list)
		$errormessage = "List must have a title and at least one item!";
	if($db_found) {		
			$SQL = $db_found->prepare("INSERT INTO lists (L1, TITLE, LIST) VALUES (?,?,?)");
			$SQL->bind_param('sss', $_SESSION['user'], $title, $list);
			$SQL->execute();
			header ("Location: page1.php");
	}
	else {
		$errormessage = "Database Not Found";
	}
}
?>
	<html>
	<head>
	<title>Lists -- New List</title>


	</head>
	<body>
<FORM NAME ="form1" METHOD ="POST" ACTION ="page1.php">
list name: <INPUT TYPE = 'TEXT' Name ='listname'  value="">
item: <INPUT TYPE = 'TEXT' Name ='item'  value="">
<P align = center>
<INPUT TYPE = "Submit" Name = "Submit1"  VALUE = "Save">



	
<P>
<a href = "mylists.php">My lists</a>
<p>
<A HREF = logout.php>Log out</A>
<P>
<?PHP print $errormessage;?>
<?PHP print "User " . $_SESSION['user'] . " Logged In";?>

	</body>
	</html>
