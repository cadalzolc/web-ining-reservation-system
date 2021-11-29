<?php
include 'database/connection2.php';
session_start();

if (!$_SESSION["id"]) {
	header("location:index.php");
}
if(isset($_POST['next'])) 
{
	header ("location: payment.php");
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
      <a class="navbar-brand" href="#">B'NING RESERVATION</a>
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
								<h3 class="panel-title">2. AMENITY
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
								<span class="glyphicon glyphicon-saved" aria-hidden="true"></span>
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
								<h3 class="panel-title">4. PAYMENT INFO</h3>
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
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong>Message!</strong> Please review your personal information.
			You cannot change your reservation once you proceed. 
		</div>
		<div class="panel panel-default">
			<div class="panel-body">
			 <h2>
			 	<center>CUSTOMER INFO</center>
			 </h2>
				<div class="container-fluid" style="text-align: center;">
					<form class="form-horizontal" role="form" id="form-pass" method="POST">
					  <div class="form-group">
					    <label for="">Reserved By:</label>
					    <input class="btn btn-default" style="width: 300px;"
								value="<?php $query = "SELECT fullname FROM client";
								$result = mysqli_query($conn,$query);
								$row = mysqli_fetch_array($result);
								echo $row["fullname"];

							?>"/>
					  </div>
					  <div class="form-group">
					    <label for="">Contact:</label>
					    <input class="btn btn-default" style="width: 332px;"
								value="<?php $query = "SELECT contact FROM client";
								$result = mysqli_query($conn,$query);
								$row = mysqli_fetch_array($result);
								echo $row["contact"];

							?>"/>
					  </div>
					  <div class="form-group">
					    <label for="">Address:</label>
					    <input class="btn btn-default" style="width: 330px;"
								value="<?php $query = "SELECT address FROM client";
								$result = mysqli_query($conn,$query);
								$row = mysqli_fetch_array($result);
								echo $row["address"];

							?>"/>
					  </div>
					<br />
					
					  <button type="submit" name="next" class="btn btn-success">NEXT
					  <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
					  </button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4"></div>
</div>

<?php require_once('admin/modal/message.php'); ?>

<script type="text/javascript" src="assets/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>

</body>
</html>

 ?>