<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Bining Resort</title>

		<!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-theme.min.css">

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
	      <li><a href="index.php"><span class="glyphicon glyphicon-backward"></span> Return Home</a></li>
	    </ul>
	</div>
</nav>



<div class="col-md-3"></div>
<div class="col-md-6">
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title">Please Register Here</h3>
		</div>
		<div class="panel-body">

			<form class="form-horizontal" role="form" id="form-pass" action="includes/signup_inc.php" method = "POST">

			  <div class="form-group">
			    <label class="control-label col-sm-2">Fullname:</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" name="fn" placeholder="Enter Fullname" autofocus="">
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="control-label col-sm-2">Address:</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" name="add" placeholder="Enter Address" autofocus="">
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="control-label col-sm-2">Contact:</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" name="con" placeholder="Enter Contact" autofocus="">
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="control-label col-sm-2">Age:</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" name="age" placeholder="Enter Age" autofocus="">
			    </div>
			  </div>

			  <div class="form-group">
				<label class="control-label col-sm-2">Gender:</label>
				<select class="btn btn-default" name="gen" style="margin-left: 13px; padding-left: 18px">
					<option value="Male">Male</option>
					<option value="Female">Female</option>
				</select>
			  </div>

			  <div class="form-group">
			    <label class="control-label col-sm-2">Username:</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" name="un" placeholder="Enter Username" autofocus="">
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="control-label col-sm-2">Password:</label>
			    <div class="col-sm-10"> 
			      <input type="password" class="form-control" name="pwd" placeholder="Enter password">
			    </div>
			  </div>
			  
			  <div class="form-group"> 
			    <div class="col-sm-offset-2 col-sm-10">
			      <button type="submit" class="btn btn-primary" name="btn-add">Register
			      <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
			      </button>
			    </div>
			  </div>
			</form>
		</div>
		<div style="text-align: center; color: blue;">
			<h4><b>
				<?php
					if (isset($_GET["error"])) 
					{
						if ($_GET["error"] == "emptyinput")
						{
							echo "<p>fields cannot be empty</p>";
						}
						elseif ($_GET["error"] == "stmtfailed")
						{
							echo "<p>Something went wrong</p>";
						}
						elseif ($_GET["error"] == "usernametaken")
						{
							echo "<p>Username has been taken</p>";
						}
						elseif ($_GET["error"] == "none")
						{
							echo "<p>Sign up Succesfully</p>";
						}
					}
				?>
			</b></h4>
		</div>
		
	</div>
</div>
<div class="col-md-3"></div>


<?php require_once('admin/modal/message.php'); ?>

<script type="text/javascript" src="../assets/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>

</body>
</html>