<!--
	Database input field script .php
-->
<?php
// Default query display
if (!isset($query_display)) {
	$query_display = "query-field";
}
?>
<form class="<?php echo $query_display;?>" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <h3><label for="query">Query:</label></h3>
	<a rel="table creation code" href="..\create_table.md">Submit this code to create tables</a>
    <textarea class="query-input-field" id="query" name="query">SELECT * FROM course_table</textarea>
	<div>
		<input type="submit" value="Submit">
		<input type="reset" value="Reset">
	</div>
</form>
<?php
// Functions
function fetchSELECT(&$conn, $query, &$arr) {
	$stmt = $conn->prepare("EXPLAIN $query");
	$stmt->execute();
	array_push($arr, "<h2>Explanation</h2>");
	array_push($arr, $stmt->fetchAll());
	
	$stmt = $conn->prepare($query);
	$stmt->execute();
	array_push($arr, "<h2>Data</h2>");
	array_push($arr, $stmt->fetchAll());
}

function fetchSHOW(&$conn, $query, &$arr) {
	$stmt = $conn->prepare($query);
	$stmt->execute();
	array_push($arr, "<h2>Data</h2>");
	array_push($arr, $stmt->fetchAll());
}

/*
// Test values
$servername = "localhost";
$port = "3307";
$dbname = "cp476";
$username = "mysql.CP476";
$password = "1111";
*/

if($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["query"]) and isset($_SESSION["password"])) {
	$dsn = "mysql:host={$_SESSION['servername']};port={$_SESSION['port']};dbname={$_SESSION['dbname']};";
	$options = [
		PDO::ATTR_EMULATE_PREPARES => false, // turn off emulation mode
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
	];
	try {
		// Connect to database
		$conn = new PDO($dsn, $_SESSION["username"], $_SESSION["password"], $options);
		// echo "Connected database: {$_SESSION['dbname']}";
		
		// Fetch based on query types
		$_SESSION["query"] = [];
		$query_type = trim(strtoupper(strtok($_POST["query"], ' ')));
		if ($query_type == "SELECT") {
			fetchSELECT($conn, $_POST["query"], $_SESSION["query"]);
		} else if ($query_type == "SHOW") {
			fetchSHOW($conn, $_POST["query"], $_SESSION["query"]);
		} else {
			array_push($_SESSION["query"], "<div>Unidentified query.</div>");
		}
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	$conn = null;
}
?>