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
<style>
* {
	box-sizing: border-box;
}
body {
	margin: 0; /* remove webpage default spacing */
}
#topnav {
	list-style-type: none; /* remove list dot */
	margin: 0;
	padding: 0;
	top: 0;
	width: 100%;
	overflow: hidden;
	background-color: #333333;
	position: sticky; /* stay on screen regardless of scroll */
}
#topnav li {
	float: left;
}
#topnav li.right_align {
	float: right;
}
#topnav li a {
	display: block;	/* make entire block clickable */
	padding: 14px 16px;
	color: white;
	text-align: center;
	text-decoration: none; /* hide link underline */
}
#topnav li a:hover:not(.active) {
	background-color: #111111;
}
#topnav .active {
	background-color: #04AA6D; /* highlights current location */
}

.column {
	float: left;
	height: 1500px;
	padding: 10px;
}
.column.side {
	width: 15%;
}
.column.middle {
	width: 70%;
	border-width: 0 1px; /* Top Bottom | Left Right */
	border-style: solid;
	border-color: #38444d;
}
.row::after {
	content: ""; /* clearfix hack */
	display: table;
	clear: both;
}
</style>
</head>
<body>
<ul id="topnav">
	<li><a class="active" href="#home">Home</a></li>
	<li><a href="#one">Docs</a></li>
	<li><a href="#two">Demo</a></li>
	<li><a href="#three">Database</a></li>
	<li class="right_align"><a href="#testtwo">Login</a></li>
</ul>
<div class="row">
	<div class="column side"></div>
	<div class="column middle">
		<h1>Welcome, <?php echo $_SESSION["user"];?>!</h1>
		<a rel="connection" href="connection.php">Connect to MySql database</a><br>
		<a rel="database" href="database.php">Go to database</a><br>
		<a title="don't click" href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">Don't Click</a><br>
		<form action="/html/logout.php" method="post">
			<input type="submit" value="Logout">
		</form>
	</div>
	<div class="column side"></div>
</div>
</body>
</html>