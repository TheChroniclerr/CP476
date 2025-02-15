<!--
	Database connection script .php
-->
<?php
// Connection message
$fmsg = "";
// Update session information before display form
if($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["disconnect"])) {
	unset($_SESSION["servername"]);
	unset($_SESSION["port"]);
	unset($_SESSION["dbname"]);
	unset($_SESSION["username"]);
	unset($_SESSION["password"]);
} else if($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["connect"]) and isset($_POST["password"])) {
	$dsn = "mysql:host={$_POST['servername']};port={$_POST['port']};dbname={$_POST['dbname']};";
	$options = [
		PDO::ATTR_EMULATE_PREPARES => false,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	];

	try {
		// Connect with attributes and settings
		$conn = new PDO($dsn, $_POST["username"], $_POST["password"], $options);	
		$fmsg = "Connection successful";
	} catch(PDOException $e) {
		$fmsg = "Connection failure: " . $e->getMessage();
	}
	$conn = null;

	// Connection successful since no exception report
	$_SESSION["servername"] = $_POST["servername"];
	$_SESSION["username"] = $_POST["username"];
	$_SESSION["password"] = $_POST["password"];
	$_SESSION["port"] = $_POST["port"];
	$_SESSION["dbname"] = $_POST["dbname"];
}

// Update form information
$fservername = isset($_SESSION["servername"]) ? $_SESSION["servername"] : "";
$fport = isset($_SESSION["port"]) ? $_SESSION["port"] : "";
$fdbname = isset($_SESSION["dbname"]) ? $_SESSION["dbname"] : "";
$fusername = isset($_SESSION["username"]) ? $_SESSION["username"] : "";
$fpassword = isset($_SESSION["password"]) ? $_SESSION["password"] : "";
?>
<form class="connection-field" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<h3>Connection:</h3>
	<div>
		<label for="servername">Hostname / IP:</label><br>
		<input type="text" id="servername" name="servername" placeholder="localhost" value="<?php echo $fservername; ?>" required><br>
	</div>
	<div>
		<label for="username">Username:</label><br>
		<input type="text" id="username" name="username" placeholder="root" value="<?php echo $fusername; ?>" required><br>
	</div>
	<div>
		<label for="password">Password:</label><br>
		<input type="password" id="password" name="password" value="<?php echo $fpassword; ?>" required><br>
	</div>
	<div>
		<label for="port">Port:</label><br>
		<input type="number" id="port" name="port" placeholder="3306 (Optional)" value="<?php echo $fport; ?>"><br>
	</div>
	<div>
		<label for="dbname">Database:</label><br>
		<input type="text" id="dbname" name="dbname" placeholder="cp476 (Optional)" value="<?php echo $fdbname; ?>"><br>
	</div>
	<div>
		<input type="submit" name="connect" value="Connect">
		<input type="reset" value="Reset">
		<input type="submit" name="disconnect" value="Disconnect">
	</div>
	<?php echo $fmsg; ?>
</form>