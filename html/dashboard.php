<?php
	session_start();
	// Directory
	$topnav_dir = '../lib/topnav/main.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Hubert Bao">
	<meta name="description" content="Homepage navigation dashboard.">
	<link rel="icon" href="/lib/favicon/favicon.ico">
	<link rel="preload" href="/lib/fonts/Roboto-Regular.ttf" as="font" type="font/ttf" crossorigin="">
	<link rel="stylesheet" href="/lib/fonts/font_family.css">
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
			border-color: #333333;
		}
	</style>
</head>
<body>
	<?php
		$topnav_currpage = "Home";
		$curr_client = isset($_SESSION["user"]) ? $_SESSION["user"] : "Guest";
		include($topnav_dir);
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