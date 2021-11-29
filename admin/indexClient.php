<?php
session_start();
?>
<!DOCTYPE html>
<html lang="">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Bining Resort</title>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap-theme.min.css">

</head>
<body>

	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<a class="navbar-brand" href="#">Bining Reservation System</a>
			<ul class="nav navbar-nav">
				<li>
					<a href="#"></a>
				</li>
				<li>
					<a href="#"></a>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="../"><span class="glyphicon glyphicon-backward"></span> Return Home</a></li>
			</ul>
		</div>
	</nav>



	<div class="col-md-3"></div>
	<div class="col-md-6">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">Please Login Here</h3>	
			</div>
			<div class="panel-body">
				<?php
				include '../database/connection2.php';

				if(isset($_POST['submit'])) 
				{
					$username = mysqli_real_escape_string($conn,$_POST["username"]);
					$Pass = mysqli_real_escape_string($conn,$_POST["pwd"]);

					$query = "SELECT * FROM client WHERE username = '$username' AND password = '$Pass'";
					$result = mysqli_query($conn,$query);
					$count = mysqli_num_rows($result);
					$row = mysqli_fetch_array($result);

					if($count == 1) {
						$_SESSION["id"] = $row["client_id"];
						$_SESSION["name"] = $row["fullname"];
						$_SESSION["add"] = $row["address"];
						$_SESSION["con"] = $row["contact"];
						$_SESSION["age"] = $row["age"];
						$_SESSION["gen"] = $row["gender"];
						$_SESSION["un"] = $row["username"];
						$_SESSION["pwd"] = $row["password"];

						$BackToMyPage = $_SERVER['HTTP_REFERER'];

						if(!isset($BackToMyPage)) {
							header('Location: '.$BackToMyPage);
						} else {
							header ('Location:../home.php');
						}
						exit;
					} else {
						echo "<script language='javascript' type='text/javascript'>alert('Invalid Email or Password!')</script>";
					}
				}
				?>
				
				<form class="form-horizontal" role="form" id="form-login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST"> 

					<div class="form-group">
						<label class="control-label col-sm-2">Username:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control"  name="username" placeholder="Enter Username" autofocus="" required="">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2">Password:</label>
						<div class="col-sm-10"> 
							<input type="password" class="form-control" name="pwd" placeholder="Enter password" required="">
						</div>
					</div>

					<div class="form-group"> 
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
								<label><input type="checkbox"> Remember me</label>
							</div>
						</div>
					</div>

					<div class="form-group"> 
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" name="submit" class="btn btn-default">Login
								<span class="glyphicon glyphicon-check" aria-hidden="true"></span>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-3"></div>


	<?php require_once('modal/message.php'); ?>

	<script type="text/javascript" src="../assets/js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
</body>
</html>