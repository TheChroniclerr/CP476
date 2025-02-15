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
<link rel ="stylesheet" href="/lib/modules/db_connection/main.css">
</head>
<body>
<?php include('../lib/modules/db_connection/main.php'); ?>
</body>
</html>