<!--
	Database connection script .php
-->
<?php
	/**
	 * Database Connection Module
	 * 
	 * Variables:
	 *    - $dbc_fmsg
	 * Usage:
	 *    - Connection post variables
	 *    - Connection session variables
	 */
	// Functions
	function check_connection() {
		$dsn = "mysql:host={$_POST['servername']};port={$_POST['port']};dbname={$_POST['dbname']};";
		$options = [
			PDO::ATTR_EMULATE_PREPARES => false,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		];
		return new PDO($dsn, $_POST["username"], $_POST["password"], $options);	
	}
	function unset_connection() {
		unset($_SESSION["servername"]);
		unset($_SESSION["port"]);
		unset($_SESSION["dbname"]);
		unset($_SESSION["username"]);
		unset($_SESSION["password"]);
	}
	// Update session information before display form
	if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["disconnect"])) {
		unset_connection();
	} else if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["connect"]) and isset($_POST["password"])) {
		try {
			check_connection();	// Check if connection possible
			// Store session variables for persistent access
			$_SESSION["servername"] = $_POST["servername"];
			$_SESSION["username"] = $_POST["username"];
			$_SESSION["password"] = $_POST["password"];
			$_SESSION["port"] = $_POST["port"];
			$_SESSION["dbname"] = $_POST["dbname"];
			$dbc_fmsg = "Connection successful";
		} catch(PDOException $e) {
			$dbc_fmsg = "Connection failure: " . $e->getMessage();
		}
		$conn = null;
	}
?>
<form class="connection-field" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<h3>Connection:</h3>
	<div>
		<label for="servername">Hostname / IP:</label><br>
		<input type="text" id="servername" name="servername" placeholder="localhost" value="<?php echo $_SESSION["servername"] ?? ""; ?>" required><br>
	</div>
	<div>
		<label for="username">Username:</label><br>
		<input type="text" id="username" name="username" placeholder="root" value="<?php echo $_SESSION["username"] ?? ""; ?>" required><br>
	</div>
	<div>
		<label for="password">Password:</label><br>
		<input type="password" id="password" name="password" value="<?php echo $_SESSION["password"] ?? ""; ?>" required><br>
	</div>
	<div>
		<label for="port">Port:</label><br>
		<input type="number" id="port" name="port" placeholder="3306 (Optional)" value="<?php echo $_SESSION["port"] ?? ""; ?>"><br>
	</div>
	<div>
		<label for="dbname">Database:</label><br>
		<input type="text" id="dbname" name="dbname" placeholder="cp476 (Optional)" value="<?php echo $_SESSION["dbname"] ?? ""; ?>"><br>
	</div>
	<div>
		<input type="submit" name="connect" value="Connect">
		<input type="reset" value="Reset">
		<input type="submit" name="disconnect" value="Disconnect">
	</div>
	<?php echo $dbc_fmsg; ?>
</form>