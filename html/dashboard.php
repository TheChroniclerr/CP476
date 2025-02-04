<?php
session_start();

// Check if user is not logged in
if (!isset($_SESSION["user"])) {
	header("Location: login.php"); // redirect back to login page
	exit();
}
?>

<!DOCTYPE html>
<html>
<head>
</head>

<body>
<h1>Welcome, <?php echo $_SESSION["user"];?>!</h1>

<form action="/html/logout.php" method="post">
	<input type="submit" value="Logout">
</form>
</body>
</html>