<?php 
session_start();
if (empty($_SESSION['s-id'])) {
	require_once("./includes/config.php");
    header('Location:' . BaseURL() . "login.php");
	exit;
}
$GLOBALS["active-page"] = "dashboard";
?>

<!DOCTYPE html>
<html lang="">
<?php include("./layouts/portal/head.php"); ?>
<body>
	<?php include("./layouts/portal/menu.php"); ?>
	<br />
	<?php 	
		if ($_SESSION['s-role-id'] == 4) {
			include("./layouts/dashboard/admin.php");
		}elseif ($_SESSION['s-role-id'] == 2) {
			include("./layouts/dashboard/customer.php");
		}
	?>
</body>
</html>