<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>B'ning Resort</title>
		<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap-theme.min.css">
		<link rel="stylesheet" type="text/css" href="./assets/css/toastr.min.css">
	</head>
	<body>

		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<a class="navbar-brand" href="#">B'ning Reservation System</a>
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
					<form method="POST" class="form-horizontal" role="form" onsubmit="return OnLoginSubmit(this);">
						<div class="form-group">
							<label class="control-label col-sm-2" for="un">Username:</label>
							<div class="col-sm-10">
							<input type="text" class="form-control" id="Username" name="Username" placeholder="Enter Username" autofocus="" required="">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="pwd">Password:</label>
							<div class="col-sm-10"> 
							<input type="password" class="form-control" id="Password" name="Password" placeholder="Enter password" required="">
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
								<button type="submit" class="btn btn-default">Login
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
			function OnLoginSubmit(frm) {
				$.post('./process/auth-login.php', $(frm).serialize(), function(res) {
					if (res.success) {
						toastr.success(res.message);
						window.location.href = res.returl;
					}else{
						toastr.error(res.message);
					}
				});
				return false;
			}
	</script>
	</body>
</html>