<!DOCTYPE html>
<html>
<head>
<style>
.query-input-field {
    width: 100%;
    height: 100px;
	box-sizing: border-box;
	background-color: #D3D3D3;
    resize: none; /* Prevents resizing if not needed */
}

.query-input-field::placeholder {
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
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <h3><label for="query">Query:</label></h3>
    <textarea class="query-input-field" id="query" name="query">SELECT * FROM course_table</textarea><br>
    <input type="submit" value="Submit">
    <input type="reset" value="Reset">
</form>
<?php
if($_SERVER["REQUEST_METHOD"] !== "POST") {
	exit();
}

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

$servername = "localhost";
$port = "3307";
$dbname = "cp476";
$username = "mysql.CP476";
$password = "1111";

try {
	// Connect to database
	$conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "connection success";
	// Fetch data as associative array
	$stmt = $conn->prepare("EXPLAIN " . $_POST["query"]);
	$stmt->execute();
	$explanation = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$stmt = $conn->prepare($_POST["query"]);
	$stmt->execute();
	$query_content = $stmt->fetchAll(PDO::FETCH_ASSOC);
	// Display tables
	echo "<h2>Explanation</h2>";
	displayContent($explanation, "query-table");
	echo "<h2>Data</h2>";
	displayContent($query_content, "query-table");
} catch(PDOException $e) {
	echo "Error: " . $e->getMessage();
}

$conn = null;
?>
</body>
</html>
