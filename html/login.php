<?php
session_start();

// Check if user is already logged in
if (isset($_SESSION["user"])) {
	header("Location: dashboard.php"); // redirect to user dashboard
	exit();
}

// Defaults
$default_username = $default_password = "admin";
$default_error_msg = "* Incorrect username or password.";

// Variables
$error = 0;

// Check for login request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_POST["username"] == $default_username and $_POST["password"] = $default_password) {
		$error = 0;
		$_SESSION["user"] = $_POST["username"]; // set session user
		header("Location: dashboard.php"); // redirect to user dashboard
		exit();
	} else {
		$error = 1;
	}
}
?>

<!DOCTYPE html>
<html>
<head>
<style>
form .login-container {
	max-width: 300px; /* Auto-adjust when screen width < 300px */
	margin: auto;
	background-color: #FFF4A3;
}

form .login-input-field {
	width: 100%;
	box-sizing: border-box; /* Adjust field width with respect to container padding */
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

.error {color: #FF0000;}
</style>
</head>

<body>

<h2 class="login-icon">Login</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<fieldset class="login-container">
		<legend>Authentication</legend>
		<label for="username">Username:</label><br>
		<input type="text" class="login-input-field" id="username" name="username" value="" placeholder="Enter your username..." required><br>
		<label for="password">Password:</label><br>
		<input type="password" class="login-input-field" id="password" name="password" value="" placeholder="Enter your password..." required><br>
		<div class="error"><?php echo $error ? $default_error_msg : "<br>"?></div>
		<input type="submit" value="Submit">
		<input type="reset" value="Reset">
    </fieldset>
</form>
</body>
</html>