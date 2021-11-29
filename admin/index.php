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
			<h3 class="panel-title" style="text-align: center;">Select Login Type</h3>
		</div>
		<div class="panel-body">
			<form class="form-horizontal" role="form" id="form-login" style="text-align: center;">

			  <div class="form-group"> 
			    <div class="col-sm-6">
			      <button type="submit" class="btn btn-default"><a href="indexAdmin.php">Login as Admin</a>
			      <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
			      </button>
			    </div>
			    <div class="col-sm-6">
			      <button type="submit" class="btn btn-default"><a href="indexClient.php">Login as Client</a>
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

<script type="text/javascript">
	$(document).on('submit', '#form-login', function(event) {
		event.preventDefault();
		/* Act on the event */
		// console.log('test');
		var un = $('#un').val();
		var pwd = $('#pwd').val();

		$.ajax({
				url: '../data/loginUser.php',
				type: 'post',
				dataType: 'json',
					data: {
						un: un,
						pwd : pwd
					},
				success: function (data) {
					// console.log(data);
					if(data.valid == true){
						window.location = data.url;
					}else{
						$('#modal-message').find('#body-cont').text(data.msg);
						$('#modal-message').modal('show');
						$('#un').val("");
						$('#pwd').val("");
						$('#un').focus();
					}
				},
				error: function(){
					alert('Error: L99+');
				}//
			});
	});

</script>

</body>
</html>