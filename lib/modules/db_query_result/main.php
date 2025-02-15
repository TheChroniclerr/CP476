<!--
	Database result table script .php
-->
<?php
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
// Process inputs
if (isset($_SESSION["query"])) {
	foreach ($_SESSION["query"] as $content) {
		if (is_string($content)) {
			echo $content;
		} else if (is_array($content)) {
			displayContent($content, "query-table");
		}
	}
	unset($_SESSION["query"]);
}
?>