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
<a rel="connection" href="connection.php">Connect to MySql database</a><br>
<a rel="database" href="database.php">Go to database</a><br>
<a title="don't click" href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">Don't Click</a><br>
<form action="/html/logout.php" method="post">
	<input type="submit" value="Logout">
</form>
</body>
</html>