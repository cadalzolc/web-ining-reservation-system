<?php
include 'database/connection2.php';
session_start();

if (!$_SESSION["id"]) {
	header("location:index.php");
}
if (isset($_GET["action"])) 
{
	if ($_GET["action"] == "delete") 
	{
		foreach ($_SESSION["reservation"] as $keys => $values)
		{
			if ($values["item_id"] == $_GET["id"]) 
			{
				unset($_SESSION["reservation"][$keys]);
			}
		}
	}
}
?>

<!DOCTYPE html>
<html lang="">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>B'ning</title>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap-theme.min.css">

</head>
<body style="background-color: lightblue;">

	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">B'ning Reservation</a>
			</div>
			<ul class="nav navbar-nav">
				<li class="active">
					<a href="reserved.php">Reservation
						<span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span>
					</a>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="home.php"><span class="glyphicon glyphicon-backward"></span> Back To Home</a></li>
			</ul>
		</div>
	</nav>


	<div class="container-fluid">
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<h3 class="panel-title">STEPS FOR RESERVATION</h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-3">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">1. RESERVATION
									</h3>
								</div>
								<div class="panel-body">
									SCHEDULE OF RESERVATION
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="panel panel-info">
								<div class="panel-heading">
									<h3 class="panel-title">2. Amenity
									</h3>
								</div>
								<div class="panel-body">
									AMENITY TYPE
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="panel panel-success">
								<div class="panel-heading">
									<h3 class="panel-title">3. CUSTOMER INFO
									</h3>
								</div>
								<div class="panel-body">
									CUSTOMER DETAILS
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="panel panel-warning">
								<div class="panel-heading">
									<h3 class="panel-title">4. PAYMENT INFO
										<span class="glyphicon glyphicon-saved" aria-hidden="true"></span>
									</h3>
								</div>
								<div class="panel-body">
									TOTAL PAYMENT
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-1"></div>
	</div>

	<div class="container-fluid">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-body">
					<h2>
						<center>PAYMENT INFO</center>
					</h2>
					<br />
					<div class="panel panel-success">
						<div class="panel-heading">
							<h3 class="panel-title"><center>DEPARTURE</center></h3>
						</div>
						<div class="panel panel-success">
							<div class="panel-heading">
								<h3 class="panel-title">CONTACT INFO</h3>
							</div>
							<div class="panel-body">
								<?php require_once('data/getBooked.php'); ?>
								<strong>Book By:</strong> <?php $query = "SELECT fullname FROM client";
								$result = mysqli_query($conn,$query);
								$row = mysqli_fetch_array($result);
								echo $row["fullname"];

								?><br /> 
								<strong>Contact #:<?php $query = "SELECT contact FROM client";
								$result = mysqli_query($conn,$query);
								$row = mysqli_fetch_array($result);
								echo $row["contact"];

								?><br />
								<strong>Address:</strong> <?php $query = "SELECT address FROM client";
								$result = mysqli_query($conn,$query);
								$row = mysqli_fetch_array($result);
								echo $row["address"];

								?><br />
							</div>
						</div>
						<div class="container-fluid">
							<strong>
								<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
							PASSENGERS</strong>
							<table id="myTable-party" class="table table-bordered table-hover" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>
											<center>
												Name
											</center> 
										</th>
										<th>
											<center>
												Age
											</center>
										</th>
										<th>
											<center>
												Gender
											</center>
										</th>
										<th>
											<center>
												Price
											</center>
										</th>
										<th>
											<center>
												Action
											</center>
										</th>
									</tr>
								</thead>
								<?php
								if(!empty($_SESSION["reservation"]))
								{
									$total = 0;
									foreach ($_SESSION["reservation"] as $key => $values)
									{
										?>
										<tr>
											<td align="center"><?php echo $_SESSION["name"]; ?></td>
											<td align="center"><?php echo $_SESSION["age"]; ?></td>
											<td align="center"><?php echo $_SESSION["gen"]; ?></td>
											<td align="right"><?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>
											<td align="center"><a href="payment.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
										</tr>
										<?php
										$total = $total + ($values["item_quantity"] * $values["item_price"]);
									}
									?>
									<td colspan="3" align="right">Total</td>
									<td align="right">$ <?php echo number_format($total, 2); ?></td>
									<?php
								}
								?>
								<strong>- Booked ID: <?= $tracker; ?></strong>
							</table>
							<center>
								<a href="home.php" class="btn btn-success">Return Home
									<span class="glyphicon glyphicon-backward" aria-hidden="true"></span>
								</a>
							</center>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3"></div>
		</div>

		<script type="text/javascript" src="assets/js/jquery-3.1.1.min.js"></script>
		<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>



	</body>
	</html>