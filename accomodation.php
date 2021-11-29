<?php
include 'database/connection2.php';
session_start();

if (!$_SESSION["id"]) {
	header("location:index.php");
}

if (isset($_POST["add_to_reserve"]))
{
	if (isset($_SESSION["reservation"]))
	{
		$item_array_id = array_column($_SESSION["reservation"], "item_id");
		if (!in_array($_GET["id"], $item_array_id)) 
		{
			$count = count($_SESSION["reservation"]);
			$item_array = array(
				'item_id'	=> $_GET['id'],
				'acc_id'	=> $_POST['acc_id'],
				'item_type'	=> $_POST['hidden_name'],
				'item_price'	=> $_POST['hidden_price'],
				'item_quantity'	=> $_POST['quantity']
			);
			$_SESSION["reservation"][$count] = $item_array;
		}
		else
		{
			echo '<script>alert("Item already Added")</script>';
			echo '<script>window.location="accomodation.php"</script>';
		}
	}
	else
	{
		$item_array = array(
			'item_id'	=> $_GET['id'],
			'acc_id'	=> $_POST['acc_id'],
			'item_type'	=> $_POST['hidden_name'],
			'item_price'	=> $_POST['hidden_price'],
			'item_quantity'	=> $_POST['quantity']
		);
		$_SESSION["reservation"] [0] = $item_array;
	}
}


if(isset($_POST['add_to_reserve'])) {

	$book_by = $_SESSION["name"];
	$book_contact = $_SESSION["con"];
	$book_address = $_SESSION["add"];
	$book_name = $_SESSION["un"];
	$book_age = $_SESSION["age"];
	$book_gender = $_SESSION["gen"];
	$book_departure = $_SESSION["departure_date"];
	$dest_id = $_SESSION['destination'];
	$acc_id = $_GET["id"];
	$origin_id = $_SESSION['origin'];
	$book_tracker = uniqid();

	$ins = "INSERT INTO booked (book_by, book_contact, book_address, book_name, book_age, book_gender, book_departure, dest_id, acc_id, origin_id, book_tracker) VALUES ('$book_by', '$book_contact', '$book_address', '$book_name', '$book_age', '$book_gender', '$book_departure', '$dest_id', '$acc_id', '$origin_id', '$book_tracker')";

	$query = mysqli_query($conn, $ins);
	header ("location: passenger.php");
}
?>

<!DOCTYPE html>
<html lang="">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>B'ning Reservation</title>

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
									<h3 class="panel-title">2. AMENITY
										<span class="glyphicon glyphicon-saved" aria-hidden="true"></span>
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
									<h3 class="panel-title">3. CUSTOMER INFO</h3>
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
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<div class="panel panel-default">
				<div class="panel-body">
					<h2>
						<center>AMENITY</center>
					</h2>
					<br/>
					<?php
					$query = "SELECT * FROM accomodation ORDER BY acc_id ASC";
					$result = mysqli_query($conn,$query);
					if(mysqli_num_rows ($result) > 0)
					{
						while($row = mysqli_fetch_array($result))
						{
							?>
							<div class="col-md-4 mt-3" style=" width: 25%;" >
								<form class="form-horizontal" role="form" id="form-acc" action="accomodation.php?action=add&id=<?php echo $row["acc_id"]; ?>" method="POST">
									<div class="card" style="border:2px solid; border-radius: 5px; background-color: white; border-color: orange;" align="center">
										<div class="card-body">

											<h4 class="card-title" style="color: red;"><?php echo $row['acc_type']; ?> </h4>
											<h4 class="card-title">Price: ₱<?php echo $row['acc_price']; ?> </h4>
											<input type="hidden" name="hidden_name" value="<?php echo $row["acc_type"]; ?>"/>
											<input type="hidden" name="hidden_price" value="<?php echo $row["acc_price"]; ?>"/>
											<p class="card-text" style="margin-bottom: 20px;">Stock: 
												<?php 
												echo $row['acc_slot'];
												?>
											</p>
											<input type="hidden" name="quantity" value="1" style="width: 30%;" />
											<div class="profile-bottom-bottom disable2" style="display: flex; flex-wrap: wrap;">

												<div class="submit-button" style="margin-left: 35%; margin-bottom: 2%;">

													<button class="btn btn-common" name="add_to_reserve" type="submit" style="background-color: #FF8C00; color: black;">Reserve</button>
													<input type="hidden" name="acc_id" value="$acc_id">
													<div id="msgSubmit" class="h3 text-center hidden"></div> 
													<div class="clearfix"></div> 
												</div>
											</div>
										</div>
									</div>
								</form>
								
							</div>
							<?php
						}
					}
					else
					{
						echo "Anemity Found";
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="assets/js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
</body>
</html>
