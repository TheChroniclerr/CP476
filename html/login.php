<?php
	session_start();
	if (isset($_SESSION["user"])) {
		header("Location: dashboard.php");
		exit();
	}
	// Directory
	$login_dir = '../lib/modules/login/main.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Hubert Bao">
	<meta name="description" content="Login page.">
	<link rel="icon" href="/lib/favicon/favicon.ico">
	<link rel="preload" href="/lib/fonts/Roboto-Regular.ttf" as="font" type="font/ttf" crossorigin="">
	<link rel="stylesheet" href="/lib/fonts/font_family.css">
	<link rel="stylesheet" href="/lib/modules/login/main.css">
	<style>
		body {
			margin: 0;
		}
		.login-icon::before {
			content: ""; /* required for rendering ::before elements */
			display: inline-block;
			background-image: url("/images/lock.png");
			background-size: contain; /* fit whole image inside block while maintaining aspect ratio */ 
			width: 32px;
			height: 32px;
			margin-right: 5px;
		}
	</style>
</head>
<body>
	<h2 class="login-icon">Login</h2>
	<?php
		include($login_dir);
	?>
</body>
</html>