<?php
session_start();
if(!isset($_SESSION["user"])) {
	header("Location: login.php");
	exit();
}
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<title>Database</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Hubert Bao">
	<meta name="description" content="Mysql database connection, query, and table display page.">
	<link rel="icon" href="/lib/favicon/favicon.ico">
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
</head>
<body>
<?php 
$topnav_currpage = "Database";
include('../lib/topnav/main.php');

include('../lib/modules/db_connection/main.php');

$query_display = "query-field-hidden";
if(isset($_SESSION["password"])) {
	$query_display = "query-field";
}
include('../lib/modules/db_query/main.php');

include('../lib/modules/db_query_result/main.php');
?>
</body>
</html>
