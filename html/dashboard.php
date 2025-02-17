<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="/lib/topnav/main.css">
<style>
* {
	box-sizing: border-box;
}
body {
	margin: 0; /* remove webpage default spacing */
}

#page_body {
	display: flex;
	justify-content: left;
	width: 100%;
	min-height: calc(100vh - 50px); /* web page always fills the full viewport height */
	overflow: auto; /* allow scrolling if content overflows */
	flex-wrap: wrap; /* Allow columns to wrap on smaller screens */
}
#page_body div {
	width: 15%;
}
#page_body .contents {
	width: 70%;
	padding: 15px;
	border-width: 0 1px; /* Top Bottom | Left Right */
	border-style: solid;
	border-color: #38444d;
}
</style>
</head>
<body>
<?php
$topnav_currpage = "Home";
$curr_client = isset($_SESSION["user"]) ? $_SESSION["user"] : "Guest";
include('../lib/topnav/main.php');
?>
<div id="page_body">
	<div></div>
	<div class="contents">
		<h1>Welcome, <?php echo $curr_client; ?>!</h1>
		<a rel="connection" href="connection.php">Connect to MySql database</a><br>
		<a rel="database" href="database.php">Go to database</a><br>
		<a title="don't click" href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">Don't Click</a><br>
		<form action="/html/redirect_logout.php" method="post">
			<input type="submit" value="Logout">
		</form>
	</div>
	<div></div>
</div>
</body>
</html>