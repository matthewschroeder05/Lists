<?PHP
$errormessage = '';
$debug = "";
session_start();
if(!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location: login.php");
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	require '../../configure.php';
	$title = trim($_POST['listname']);
	$list = trim($_POST['item'], " ,");
	$database = "lists";
	$db_found = new mysqli(DB_SERVER, DB_USER, DB_PASS, $database);
	if($title && $list) {
		if($db_found) {		
			$SQL = $db_found->prepare("INSERT INTO lists (L1, TITLE, LIST) VALUES (?,?,?)");
			$SQL->bind_param('sss', $_SESSION['user'], $title, $list);
			$SQL->execute();
			header ("Location: mylists.php");
		}
		else $errormessage = "Database Not Found";
	}
	else $errormessage = "List must have a Title and at least one Item!";
}
?>
<html>
	<head>
		<title>New List</title>
		<link rel="stylesheet" type="text/css" href="liststyle.css">
	</head>
	<body>
		<div class="main-container">
			<div class="listtitle">New List</div>
			<div class="list-container">
				<p>Create a new List</p>
		<form NAME ="form1" METHOD ="POST" ACTION ="newlist.php">
		list name: <INPUT TYPE = 'TEXT' Name ='listname'  value="">
		<br>
		<br>
		item: <INPUT TYPE = 'TEXT' Name ='item'  value="">
		<p>You may enter more than one item by seperating each item with a comma (",")</p>
		<br>
		<INPUT TYPE = "Submit" Name = "Submit1"  VALUE = "Save">
		<br>
		<br>
		<a href = "mylists.php">My lists</a>
		<a href = logout.php>Log out</a>
		<br>
		</div>
	<?PHP print $errormessage;?>
</div>
	</body>
</html>
