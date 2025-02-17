<?php
// session_destroy(); // End the session
session_start();
unset($_SESSION["user"]);
header("Location: login.php"); // Redirect to login page
exit();
?>

/*
<!DOCTYPE html>
<html>
<head>
</head>

<body>
</body>
</html>
*/