<?PHP
$uname = "";
$pword = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
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

		if ($result->num_rows == 1) {

			$db_field = $result->fetch_assoc();

			if (password_verify($pword, $db_field['L2'])) {
				session_start();
				$_SESSION['login'] = "lists_logged_in";
				$_SESSION['user'] = $uname;
				header ("Location: mylists.php");
			}
			else {
				$errorMessage = "Login FAILED";
				session_start();
				$_SESSION['login'] = '';
			}
		}
		else {
			$errorMessage = "username FAILED";
		}
	}
}
?>

<html>
<head>
<title>Lists Login</title>
<link rel="stylesheet" type="text/css" href="liststyle.css">
</head>
<body>
	<div class="main-container">
		<div class="listtitle">Login to Lists</div>
		<div class="list-container">

<FORM NAME ="form1" METHOD ="POST" ACTION ="login.php">
Username: <INPUT TYPE = 'TEXT' Name ='username'  value="" maxlength="20">
<br>
<br>
Password: <INPUT TYPE = 'password' Name ='password'  value="" maxlength="16">
<br>
<br>

<INPUT TYPE = "Submit" Name = "Submit1"  VALUE = "Login">
</FORM>
</div>
<?PHP print $errorMessage;?>
</div>

</body>
</html>