<!--
	Database result table script .php
-->
<?php
	/**
	 * Database Query Result Module
	 * 
	 * Usage:
	 *	  - $_SESSION["query"]
	 */
	// Display associative array as table
	function display_content($result, $style) {
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
	// Display a modifiable version of the table
	function display_content_mod($result, $style) {
		// Create table
		echo "<div class=\"$style-container\"><table class=\"$style\">";
		if (!empty($result)) {
			// Table headers
			echo "<thead>";
			echo "<tr>";
			echo "<th></th>"; // 2 empty headers for mod buttons
			echo "<th></th>";
			foreach (array_keys($result[0]) as $column) {
				echo "<th>" . htmlspecialchars($column ?? "") . "</th>";
			}
			echo "</tr>";
			echo "</thead>";
			// Table cells
			echo "<tbody>";
			foreach ($result as $row) {
				echo "<tr>";
				echo "<td onclick='convertToForm(this)'><img src='https://cdn-icons-png.flaticon.com/512/84/84380.png' alt='Update'></td>"; // Create insert button
				echo "<td onclick=\"modifyRecord(this,'delete')\"><img src='https://cdn-icons-png.flaticon.com/512/3405/3405244.png' alt='Delete'></td>"; // Create delete button
				foreach ($row as $cell) {
					echo "<td>" . htmlspecialchars($cell ?? "") . "</td>";
				}
				echo "</tr>";
			}
			echo "</tbody>";
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
				// display_content($content, "query-table");
				display_content_mod($content, "query-table");
			}
		}
		unset($_SESSION["query"]);
	}
?>