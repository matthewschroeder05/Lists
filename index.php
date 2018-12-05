<?PHP
session_start();
if ((isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location: mylists.php");
}

$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require '../../configure.php';
	$uname = $_POST['username'];
	$pword = $_POST['password'];
	$database = "lists";
	$db_found = new mysqli(DB_SERVER, DB_USER, DB_PASS, $database);
	
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
		<div class="main-container">
			<div class="listtitle">Welcome to Lists!</div>
			<div class="list-container">
				<form name ="form1" method ="post" action ="index.php">
					<p>Register for an account:</p>
					Username: <input type = 'text' name ='username'  value="" >
					<br>
					<br>
					Password: <input type = 'password' name ='password'  value="" >
					<br>
					<br>
					<input type = "submit" name = "Submit1"  value = "Register">
				</form>
				<br>
				Already have an account? <a href="login.php">Sign in</a>
			</div>
			<?PHP print $errorMessage;?> 
		</div>
	</body>
</html>
