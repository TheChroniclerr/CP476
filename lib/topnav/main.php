<!--
	Top navigation menu script .php
-->
<?php
function getLog() {
	if(isset($_SESSION["user"])) {
		echo '<a class="right-align" href="redirect_logout.php">Logout</a>';
	} else {
		echo '<a class="right-align" href="login.php">Login</a>';
	}
}

// Check for active page
$topnav_active = [
	"Home" => "",
	"Docs" => "",
	"Demo" => "",
	"Database" => ""
];
if(isset($topnav_currpage)) {
	$topnav_active[$topnav_currpage] = "active"; /* current page is in topnav */
}
?>
<div id="topnav">
	<a class="<?php echo $topnav_active["Home"]; ?>" href="dashboard.php">Home</a>
	<a class="<?php echo $topnav_active["Docs"]; ?>" href="../README.md">Docs</a>
	<a class="<?php echo $topnav_active["Demo"]; ?>" href="#two">Demo</a>
	<a class="<?php echo $topnav_active["Database"]; ?>" href="database.php">Database</a>
	<?php getLog(); ?>
</div>