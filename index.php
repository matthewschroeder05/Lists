<?PHP
session_start();
if ((isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location: mylists.php");
}

// $uname = "";
// $pword = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require '../../configure.php';

	$uname = $_POST['username'];
	$pword = $_POST['password'];

	$database = "lists";

	$db_found = new mysqli(DB_SERVER, DB_USER, DB_PASS, $database );

	if ($db_found) {		
		$SQL = $db_found->prepare('SELECT * FROM login WHERE L1 = ?');
		$SQL->bind_param('s', $uname);
		$SQL->execute();
		$result = $SQL->get_result();

		if ($result->num_rows > 0) {
			$errorMessage = "Username already taken";
		}
		else {
			$phash = password_hash($pword, PASSWORD_DEFAULT);
			$SQL = $db_found->prepare("INSERT INTO login (L1, L2) VALUES (?, ?)");
			$SQL->bind_param('ss', $uname, $phash);
			$SQL->execute();

			header ("Location: login.php");
		}
	}
	else {
		$errorMessage = "Database Not Found";
	}
}
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="liststyle.css">
<title>Welcome to Lists</title>
</head>
<body>
<FORM NAME ="form1" METHOD ="POST" ACTION ="index.php">
Username: <INPUT TYPE = 'TEXT' Name ='username'  value="" >
Password: <INPUT TYPE = 'password' Name ='password'  value="" >
<P>
<INPUT TYPE = "Submit" Name = "Submit1"  VALUE = "Register">
</FORM>
<P>
Already have an account? <a href="login.php">Sign in</a>
<?PHP print $errorMessage;?> 

</body>
</html>
