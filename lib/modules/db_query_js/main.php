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
	function fetch_contents(&$stmt) {
		$arr = [];
		$stmt->execute();
		array_push($arr, $stmt->fetchAll());
		return $arr;
	}
	function fetch_tables(&$conn, &$arr) {
		$arr = [];
		// Fetch tables
		$stmt = $conn->prepare("SHOW tables");
		$stmt->execute();
		array_push($arr, $stmt->fetchAll());
		// Create form
		if (!empty($arr)) {
			echo "<form action=''>";
			echo "<label for='tables'> Tables:</label>"; // Label
			echo "<select id='tables' name ='table'>";
			// Create dropdown items
			foreach ($arr[0] as $table) {
				echo "<option value='", $table, "'>" $table, $"</option>";
			}
			echo "</select>";
			echo "<input type='submit'>"; // Submit
			echo "</form>";
		} else {
			echo "No existing table.";
		}
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
	// Procedure
	// Retrieve
	$js_data = json_decode(file_get_contents("php://input"), true);
	if ($js_data and isset($_SESSION["password"])) {
		try {
			$conn = connect();
			/*
			$prepare_delete = $conn->prepare("DELETE FROM table_name WHERE pk_1='pk_value_1' AND");
			$prepare_insert = $conn->prepare("INSERT INTO table_name () VALUES ()");
			$prepare_update = $conn->prepare("UPDATE table_name SET WHERE AND");
			$prepare_select = $conn->prepare("SELECT * FROM table_name");
			*/
			$prepare_table = $conn->prepare("SHOW tables");
			$curr_table = fetch_contents($prepare_table)[0][0];
			
			$prepare_pk = $conn->prepare("SHOW KEYS FROM table_name WHERE Key_name = 'PRIMARY'");
			$prepare_pk->bindParam(':table_name', $curr_table);
			$pk_list = fetch_contents($prepare_pk);
			/*
			$pk_names = [$pk_list[0]["Column_name"]];
			$pk_string = $pk_list[0]["Column_name"];
			for ($i = 1; $i < count($pk_list); $i++) {
				$pk_string .= " AND " . $pk_list[$i]["Column_name"];
				array_push($pk_names, $pk_list[$i]["Column_name"]);
			} */
			$pk_names = [];
			foreach ($pk_list as $pk) {
				array_push($pk_names, $pk["Column_name"]);
			}
			
			$pk_string = "WHERE pk0=val0";
			for ($i = 1; $i < count($pk_names); $i++) {
				$pk_string .= " AND " . "pk" . $i . "=val" . $i; 
			}
			
			$result = [];
			if (js_data["query_type"] == "delete") {
				$delete_string = "DELETE FROM table_name " . $pk_string;
				$prepare_delete = $conn->prepare($delete_string);
				$prepare_delete->bindParam(':table_name', $curr_table);
				$js_query_delete = $js_data["query_content"]["target"];
				for ($i = 0; $i < count($pk_names); $i++) {
					$prepare_delete->bindParam(':pk' . $i, $pk_names);
					$prepare_delete->bindParam(':val' . $i, $js_query_delete[$pk_names]);
				}
				$result = fetch_contents($prepare_delete);
			} else if (js_data["query_type"] == "update") {
				$js_query_update_change = $js_data["query_content"]["change"];
				$js_query_update_target = $js_data["query_content"]["target"];
				
				$update_string = "UPDATE table_name SET up0 = upv0";
				for (($i = 1; $i < count($js_query_update_change); $i++) {
					$update_string .= ", up" . $i . "=upv" . $i;
				}
				$update_string .= $pk_string;
				
				$prepare_update = $conn->prepare($update_string);
				$prepare_update->bindParam(':table_name', $curr_table);
				$i = 0;
				foreach ($js_query_update_change as $attribute => $change) {
					$prepare_update->bindParam(':up' . $i, $attribute);
					$prepare_update->bindParam(':upv' . $i, $change);
					$i++;
				}
				for ($i = 0; $i < count($pk_names); $i++) {
					// bind primary key of target value
					$prepare_update->bindParam(':pk' . $i, $pk_names);
					$prepare_update->bindParam(':val' . $i, $js_query_update_target[$pk_names]);
				}
				$result = fetch_contents($prepare_update);
			} else if (js_data["query_type"] == "insert") {
				$js_query_insert = $js_data["query_content"]["change"];
				
				$insert_string = "INSERT INTO table_name " . $pk_string;
				$pre_string = "(";
				$post_string = " VALUES (";
				for ($i = 0; $i < count($js_query_insert); $i++) {
					$pre_string .= 'ins' . $i . ", ";
					$post_string .= 'insv' . $i . ", ";
					$i++;
				}
				$pre_string = substr($pre_string, 0, -2);
				$post_string = substr($post_string, 0, -2);
				$pre_string .= ")";
				$post_string .= ")";
				$insert_string .= $pre_string . $post_string;
				
				$prepare_insert = $conn->prepare($insert_string);
				$prepare_insert->bindParam(':table_name', $curr_table);
				$i = 0
				for ($js_query_insert as $attribute => $change) {
					$prepare_insert->bindParam(':ins' . $i, $attribute);
					$prepare_insert->bindParam(':insv' . $i, $change);
					$i++;
				}
				$result = fetch_contents($prepare_insert);
			}
			display_content_mod($content, "query-table");
		} catch(PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	} else {
		echo "No data received.";
	}
?>