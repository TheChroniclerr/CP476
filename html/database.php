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
