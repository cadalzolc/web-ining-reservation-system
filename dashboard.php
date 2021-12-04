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
<?php include("./layouts/portal/head.php") ?>
<body>

	<?php include("./layouts/portal/menu.php") ?>
	<br />
	<div class="container-fluid">
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<div id="trans-table"></div>
		</div>
		<div class="col-md-1"></div>
	</div>

	<script type="text/javascript" src="./assets/js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="./assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="./assets/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="./assets/js/dataTables.bootstrap.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function () {
			GetPendingReservations();
		});

		function GetPendingReservations() {
			$.get("./process/get-list-reservation.php", function (res) {
				$('#trans-table').html(res);
			});
		}
	</script>

</body>

</html>