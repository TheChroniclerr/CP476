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
<link rel = "stylesheet" href="/lib/connection/main.css">
</head>
<body>
<?php include('../lib/connection/main.php'); ?>
</body>
</html>