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
<link rel="stylesheet" href="/lib/modules/db_connection/main.css">
<style>
.query-field-hidden {
	display: none;
}
.query-field textarea{
    width: 100%;
    height: 100px;
	box-sizing: border-box;
	background-color: #D3D3D3;
    resize: none; /* Prevents resizing if not needed */
}
.query-field textarea::placeholder {
    vertical-align: top;
}

.query-table-container {
	width: 100%;
	overflow: auto;
	white-space: nowrap;
}
.query-table {
	border: none;
	border-collapse: collapse;
}
.query-table tr:nth-child(even) {
	background-color: #f2f2f2;
}
.query-table th, td {
	text-align: left;
	padding: 8px;
}
.query-table th {
	text-align: center;
	background-color: #9E9E9E;
	font-weight: bold;
}
.query-table tr:hover {
	background-color: #d0ebff;
}

</style>
</head>
<body>
<?php include('../lib/modules/db_connection/main.php'); ?>
<?php
$query_display = "query-field-hidden";
if(isset($_SESSION["password"])) {
	$query_display = "query-field";
}
?>
<form class="<?php echo $query_display;?>" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <h3><label for="query">Query:</label></h3>
	<a rel="table creation code" href="..\create_table.md">Submit this code to create tables</a>
    <textarea class="query-input-field" id="query" name="query">SELECT * FROM course_table</textarea><br>
    <input type="submit" value="Submit">
    <input type="reset" value="Reset">
</form>
<?php
// Functions
// Display associative array as table
function displayContent($result, $style) {
	// Create table
	echo "<div class=\"$style-container\"><table class=\"$style\">";
	// Table contents
	if (!empty($result)) {
		// Table headers
		echo "<tr>";
		foreach (array_keys($result[0]) as $column) {
			// ?? is the nul coalescing operator, here it coalasce to ""
			echo "<th>" . htmlspecialchars($column ?? "") . "</th>";
		}
		echo "</tr>";
		// Table cells
		foreach ($result as $row) {
			echo "<tr>";
			foreach ($row as $cell) {
				echo "<td>" . htmlspecialchars($cell ?? "") . "</td>";
			}
			echo "</tr>";
		}
	} else {
		echo "<tr><td>No results found</td></tr>";
	}
	echo "</table></div>";
}

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

if($_SERVER["REQUEST_METHOD"] == "POST" and isset($_SESSION["password"]) and isset($_POST["query"])) {
	$dsn = "mysql:host={$_SESSION['servername']};port={$_SESSION['port']};dbname={$_SESSION['dbname']};";
	$options = [
		PDO::ATTR_EMULATE_PREPARES => false, // turn off emulation mode
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
	];
	try {
		// Connect to database
		$conn = new PDO($dsn, $_SESSION["username"], $_SESSION["password"], $options);
		// $conn->exec("USE {$_SESSION['dbname']};");
		echo "Connected to database: {$_SESSION['dbname']}";
		// Fetch based on query types
		$contents = [];
		$query_type = trim(strtoupper(strtok($_POST["query"], ' ')));
		if ($query_type == "SELECT") {
			fetchSELECT($conn, $_POST["query"], $contents);
		} else if ($query_type == "SHOW") {
			fetchSHOW($conn, $_POST["query"], $contents);
		} else {
			array_push($contents, "<div>Query success.</div>");
		}
		// Display tables
		foreach ($contents as $content) {
			if (is_string($content)) {
				echo $content;
			} else if (is_array($content)) {
				displayContent($content, "query-table");
			}
		}
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	$conn = null;
}
?>
</body>
</html>
