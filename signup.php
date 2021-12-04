<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>Bining Resort</title>
		<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap-theme.min.css">
	</head>
<body>

<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<a class="navbar-brand" href="#">B'ning Reservation System</a>
		<ul class="nav navbar-nav navbar-right">
	      <li><a href="index.php"><span class="glyphicon glyphicon-backward"></span>Back to Website</a></li>
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

			<form method = "POST" class="form-horizontal" role="form" onsubmit="return OnRegisterSubmit(this);">

			  <div class="form-group">
			    <label class="control-label col-sm-3">First Name:</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" name="NameF" placeholder="First Name" autofocus="" required="">
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="control-label col-sm-3">Middle Name:</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" name="NameM" placeholder="Middle Name" autofocus="" required="">
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="control-label col-sm-3">Last Name:</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" name="NameL" placeholder="Last Name" autofocus="" required="">
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="control-label col-sm-3">Age:</label>
			    <div class="col-sm-9">
			      <input type="number" class="form-control" name="Age" placeholder="Enter Age" autofocus="" required="">
			    </div>
			  </div>

			  <div class="form-group">
				<label class="control-label col-sm-3">Gender:</label>
				<select class="btn btn-default" name="Gender" style="margin-left: 13px; padding-left: 18px" required="">
					<option value="M">Male</option>
					<option value="F">Female</option>
				</select>
			  </div>

			  
			  <div class="form-group">
			    <label class="control-label col-sm-3">Address:</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" name="Address" placeholder="Enter Address" autofocus="" required="">
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="control-label col-sm-3">Contact:</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" name="Contact" placeholder="Enter Contact" autofocus="" required="">
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="control-label col-sm-3">Email:</label>
			    <div class="col-sm-9"> 
			      <input type="email" class="form-control" name="Email" placeholder="Enter Email" required="">
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="control-label col-sm-3">Username:</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" name="Username" placeholder="Enter Username" autofocus="" required="">
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="control-label col-sm-3">Password:</label>
			    <div class="col-sm-9"> 
			      <input type="password" class="form-control" name="Password" placeholder="Enter password" required="">
			    </div>
			  </div>
			  
			  <div class="form-group"> 
			    <div class="col-sm-offset-2 col-sm-9">
			      <button id="BtnReg" type="submit" class="btn btn-primary">Register
			      <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
			      </button>
			    </div>
			  </div>
			</form>
		</div>
	</div>
</div>
<div class="col-md-3"></div>

		<script type="text/javascript" src="./assets/js/jquery-3.1.1.min.js"></script>
		<script type="text/javascript" src="./assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="./assets/js/toastr.min.js"></script>
		<script type="text/javascript">
			function OnRegisterSubmit(frm) {
				$.post('./process/auth-register.php', $(frm).serialize(), function(res) {
					if (res.success) {
						toastr.success(res.message);
						$("#BtnReg").attr("disabled", true);
						setTimeout(function(){ 
							window.location.href = res.returl;
						 }, 2000);
					}
					else{
						toastr.error(res.message);
					}
				});
				return false;
			}
		</script>
	</body>
</html>