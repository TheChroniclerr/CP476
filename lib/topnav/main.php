<!--
	Top navigation menu script .php
-->
<?php
	/**
	 * Top Navigation Menu Module
	 * 
	 * Variables:
	 *	  - $topnav_currpage
	 * Usage:
	 *    - $_SESSION["user"]
	 */
	// Function
	function get_login_status() {
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
	<a href="dashboard.php"><img src="/images/favicon.ico" alt="Logo"></a>
	<a class="<?php echo $topnav_active["Home"]; ?>" href="dashboard.php">Home</a>
	<a class="<?php echo $topnav_active["Docs"]; ?>" href="../README.md">Docs</a>
	<a class="<?php echo $topnav_active["Demo"]; ?>" href="#two">Demo</a>
	<a class="<?php echo $topnav_active["Database"]; ?>" href="database.php">Database</a>
	<?php get_login_status(); ?>
</div>