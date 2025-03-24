<?php
	session_start();
	if(!isset($_SESSION["user"])) {
		header("Location: login.php");
		exit();
	}
	// Directory
	$topnav_dir = '../lib/topnav/main.php';
	$db_connection_dir = '../lib/modules/db_connection/main.php';
	$db_query_dir = '../lib/modules/db_query/main.php';
	$db_query_result = '../lib/modules/db_query_result/main.php';
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<title>Database</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Hubert Bao">
	<meta name="description" content="Mysql database connection, query, and table display page.">
	<link rel="icon" href="/images/favicon.ico">
	<link rel="preload" href="/lib/fonts/Roboto-Regular.ttf" as="font" type="font/ttf" crossorigin="">
	<link rel="stylesheet" href="/lib/fonts/font_family.css">
	<link rel="stylesheet" href="/lib/topnav/main.css">
	<link rel="stylesheet" href="/lib/modules/db_connection/main.css">
	<link rel="stylesheet" href="/lib/modules/db_query_result/main.css">
	<link rel="stylesheet" href="/lib/modules/db_query/main.css">
	<style>
		body {
			margin: 0;
		}
	</style>
	<script>
	var db_url = "js_query.php";
	var stateStorage = {};
	function _getStorageHash(record) {
		return Array.from(record.parentElement.parentElement.children).indexOf(record.parentElement);
	}
	function _fetchRecord(record) {
		// Variables
		let recordObj = {};
		// Paths
		let table = record.parentElement.parentElement.parentElement;
		let headers = table.children[0].children[0].children;
		let datas = record.parentElement.children;
		// Create record Object
		if (datas[2].children.length === 0) { // No user input
			for (let i = 2; i < headers.length; i++) {
				recordObj[headers[i].innerHTML] = datas[i].innerHTML;
			}
		} else { // Retrieve value from textbox
			for (let i = 2; i < headers.length; i++) {
				recordObj[headers[i].innerHTML] = datas[i].children[0].value;
			}
		}
		return recordObj
	}
	function convertToForm(self) {
		// Paths
		let checkIcon = "https://cdn-icons-png.flaticon.com/512/447/447147.png";
		let cancelIcon = "https://cdn-icons-png.flaticon.com/512/1828/1828528.png";

		let table = self.parentElement.parentElement.parentElement;
		let headers = table.children[0].children[0].children;
		let datas = self.parentElement.children;

		// Store current state
		stateStorage[_getStorageHash(self)] = _fetchRecord(self);
		// Change td with icons
		datas[0].setAttribute("onclick", "modifyRecord(this, 'update')");
		datas[0].children[0].setAttribute("src", checkIcon);
		datas[0].children[0].setAttribute("alt", "Insert");

		datas[1].setAttribute("onclick", "returnState(this)");
		datas[1].children[0].setAttribute("src", cancelIcon);
		datas[1].children[0].setAttribute("alt", "Cancel");
		// Change to fillables
		for (let i = 2; i < headers.length; i++) {
			datas[i].innerHTML = '<input type="text" value="' + datas[i].innerHTML + '">';
		}
	}
	/* Deprecated - does not use persistant state after conversion
	function convertToForm(self) {
		// Paths
		let checkIcon = "https://cdn-icons-png.flaticon.com/512/447/447147.png";
		let cancelIcon = "https://cdn-icons-png.flaticon.com/512/1828/1828528.png";

		let table = self.parentElement.parentElement.parentElement;
		let headers = table.children[0].children[0].children;
		let datas = self.parentElement.children;
		// Variables
		let formDict = {};
		// Procedure
		// Change icons
		datas[0].children[0].setAttribute("src", checkIcon);
		datas[0].children[0].setAttribute("alt", "Insert");
		datas[1].children[0].setAttribute("src", cancelIcon);
		datas[1].children[0].setAttribute("alt", "Cancel");
		// Change to fillables
		for (let i = 2; i < headers.length; i++) {
			formDict[headers[i].innerHTML] = datas[i].innerHTML;
			datas[i].innerHTML = '<input type="text" value="' + datas[i].innerHTML + '">';
		}
		// Pass original contents to new buttons
		datas[0].setAttribute("onclick", "updateRecord(" + JSON.stringify(formDict) + ", 'insert')");
		datas[1].setAttribute("onclick", "discardChange(this," + JSON.stringify(formDict) + ")");
	}
	function discardChange(self, prev) {
		// Paths
		// self.innerHTML = typeof prev;
		let modifyIcon = 'https://cdn-icons-png.flaticon.com/512/84/84380.png';
		let deleteIcon = 'https://cdn-icons-png.flaticon.com/512/3405/3405244.png';
		
		let datas = self.parentElement.children;
		// Variables
		prev = Object.values(prev);
		// Procedure
		// Revert icons
		datas[0].setAttribute("onclick", "convertToForm(this)");
		datas[0].children[0].setAttribute("src", modifyIcon);
		datas[0].children[0].setAttribute("alt", "Update");
		
		datas[1].setAttribute("onclick", "updateRecord('','delete')");
		datas[1].children[0].setAttribute("src", deleteIcon);
		datas[1].children[0].setAttribute("alt", "Delete");
		// Revert record
		for (let i = 2; i < datas.length; i++) {
			datas[i].innerHTML = prev[i - 2];
		}
	}
	*/
	function returnState(self) {
		// Paths
		let modifyIcon = 'https://cdn-icons-png.flaticon.com/512/84/84380.png';
		let deleteIcon = 'https://cdn-icons-png.flaticon.com/512/3405/3405244.png';
		
		let datas = self.parentElement.children;
		// Variables
		prev = Object.values(stateStorage[_getStorageHash(self)]);

		// Revert icons
		datas[0].setAttribute("onclick", "convertToForm(this)");
		datas[0].children[0].setAttribute("src", modifyIcon);
		datas[0].children[0].setAttribute("alt", "Update");
		
		datas[1].setAttribute("onclick", "modifyRecord(this,'delete')");
		datas[1].children[0].setAttribute("src", deleteIcon);
		datas[1].children[0].setAttribute("alt", "Delete");
		// Revert record
		for (let i = 2; i < datas.length; i++) {
			datas[i].innerHTML = prev[i - 2];
		}
	}
	function modifyRecord(self, type) {
		let request = {
			query_type: type,
			query_content: {
				target: '',
				change: ''
			}
		};
		
		if (type == "delete") {
			request['query_content']['target'] = _fetchRecord(self);
		} else if (type == "insert") {
			request['query_content']['change'] = _fetchRecord(self);
		} else if (type == "update") {
			request['query_content']['target'] = stateStorage[_getStorageHash(self)];
			request['query_content']['change'] = _fetchRecord(self);
		} else if (type == "select") {
			// should be implemented for table selections
		}
		_deliverQuery(request);
	}
	function _deliverQuery(data) {
		fetch(db_url, {
			method: "POST",
			headers: {"Content-Type": "application/json"}, // Set the content type to JSON
			body: JSON.stringify(data) // Convert the JavaScript object to JSON string for parse
		})
		.then(response => response.text())
		.then(data => console.log(data))
		.catch(error => console.error("Error:", error));
	}
	</script>
</head>
<body>
	<?php 
		$topnav_currpage = "Database";
		$query_display = "query-field-hidden";
		include($topnav_dir);
		include($db_connection_dir);
		if(isset($_SESSION["password"])) {
			$query_display = "query-field";
		}
		include($db_query_dir);
		include($db_query_result);
	?>
</body>
</html>
