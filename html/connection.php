<?php
session_start();

if(!isset($_SESSION["user"])) {
	header("Location: login.php");
	exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<style>
.connection-field div {
	display: flex;
	margin: 4px;
}

.connection-field label {
	flex 1;
	min-width: 200px;
	text-align: left;
	font-weight: bold;
}

.connection-field input {
	flex 2;
	text-align: left;
}
</style>
</head>
<body>
<form class="connection-field" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<div>
		<label for="servername">Hostname / IP:</label><br>
		<input type="text" id="servername" name="servername" placeholder="localhost" required><br>
	</div>
	<div>
		<label for="username">Username:</label><br>
		<input type="text" id="username" name="username" placeholder="root" required><br>
	</div>
	<div>
		<label for="password">Password:</label><br>
		<input type="text" id="password" name="password" required><br>
	</div>
	<div>
		<label for="port">Port:</label><br>
		<input type="number" id="port" name="port" placeholder="3306 (Optional)"><br>
	</div>
	<div>
		<label for="dbname">Database:</label><br>
		<input type="text" id="dbname" name="dbname" placeholder="cp476" required><br>
	</div>
	<div>
		<input type="submit" value="Connect">
		<input type="reset" value="Reset">
	</div>
</form>

<?php
if($_SERVER["REQUEST_METHOD"] !== "POST" and !isset($_POST["password"])) {
	exit();
}

try {
	$conn = new PDO("mysql:host={$_POST['servername']};port={$_POST['port']};dbname={$_POST['dbname']};", $_POST["username"], $_POST["password"]);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// connection successful since no exception report
	$_SESSION["servername"] = $_POST["servername"];
	$_SESSION["username"] = $_POST["username"];
	$_SESSION["password"] = $_POST["password"];
	$_SESSION["port"] = $_POST["port"];
	$_SESSION["dbname"] = $_POST["dbname"];
	echo "Connection successful";
} catch(PDOException $e) {
	echo "Connection failure: " . $e->getMessage();
}
$conn = null;
?>
</body>
</html>