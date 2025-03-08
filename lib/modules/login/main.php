<!--
	Login page script .php
-->
<?php
// Variables
$login_default_username = $login_default_password = "admin";
$login_default_error_msg = "* Incorrect username or password.";
// Check for login request
$login_error = "<br>";
if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["login_password"])) {
	if ($_POST["login_username"] == $login_default_username and $_POST["login_password"] == $login_default_password) {
		$login_error = 0;
		$_SESSION["user"] = $_POST["login_username"]; // set session user
		header("Location: dashboard.php"); // redirect to user dashboard
		exit();
	} else {
		$login_error = $login_default_error_msg;
	}
}
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<fieldset class="login-container">
		<legend>Authentication</legend>
		<label for="username">Username:</label><br>
		<input type="text" id="username" name="login_username" value="" placeholder="Enter your username..." required><br>
		<label for="password">Password:</label><br>
		<input type="password" id="password" name="login_password" value="" placeholder="Enter your password..." required><br>
		<div><?php echo $login_error?></div>
		<input type="submit" value="Submit">
		<input type="reset" value="Reset">
    </fieldset>
</form>