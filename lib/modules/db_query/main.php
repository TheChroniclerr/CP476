<!--
	Database input field script .php
-->
<?php
	/**
	 * Database Query Module
	 * 
	 * Variables:
	 *    - $query_type
	 * Usage:
	 *    - $_POST["query"]
	 *	  - $_SESSION["query"]
	 *    - Connection session variables
	 */
	// Default query display
	if (!isset($query_display)) {
		$query_display = "query-field";
	}
?>
<form class="<?php echo $query_display;?>" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <h3><label for="query">Query:</label></h3>
	<a rel="table creation code" href="..\create_table.md">Submit this code to create tables</a>
    <textarea class="query-input-field" id="query" name="query">SELECT * FROM course</textarea>
	<div>
		<input type="submit" value="Submit">
		<input type="reset" value="Reset">
	</div>
</form>
<?php
	// Functions
	if (!function_exists("connect")) {
		function connect() {
			$dsn = "mysql:host={$_SESSION['servername']};port={$_SESSION['port']};dbname={$_SESSION['dbname']};";
			$options = [
				PDO::ATTR_EMULATE_PREPARES => false,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			];
			return new PDO($dsn, $_SESSION["username"], $_SESSION["password"], $options);	
		}
	}
	function execute_query(&$conn, $query, &$arr) {
		$conn->exec($query);
		array_push($arr, "<div>Query successful.</div>");
	}
	function fetch_SELECT(&$conn, $query, &$arr) {
		$stmt = $conn->prepare("EXPLAIN $query");
		$stmt->execute();
		array_push($arr, "<h2>Explanation</h2>");
		array_push($arr, $stmt->fetchAll());
		
		$stmt = $conn->prepare($query);
		$stmt->execute();
		array_push($arr, "<h2>Data</h2>");
		array_push($arr, $stmt->fetchAll());
	}
	function fetch_SHOW(&$conn, $query, &$arr) {
		$stmt = $conn->prepare($query);
		$stmt->execute();
		array_push($arr, "<h2>Data</h2>");
		array_push($arr, $stmt->fetchAll());
	}
	// Procedure
	if($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["query"]) and isset($_SESSION["password"])) {
		try {
			$conn = connect();
			// Fetch based on query types
			$_SESSION["query"] = [];
			$query_type = trim(strtoupper(strtok($_POST["query"], ' ')));
			if ($query_type == "SELECT") {
				fetch_SELECT($conn, $_POST["query"], $_SESSION["query"]);
			} else if ($query_type == "SHOW") {
				fetch_SHOW($conn, $_POST["query"], $_SESSION["query"]);
			} else {
				// Unsafe multi-query executions
				execute_query($conn, $_POST["query"], $_SESSION["query"]);
			}
		} catch(PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	}
?>