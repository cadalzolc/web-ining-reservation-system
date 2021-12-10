<?php 

session_start();

$reservation_no = $_REQUEST['trn'];
$checkin_date = $_REQUEST['date'];
$name = $_REQUEST['name'];

?>

<!DOCTYPE html>
<htm>

    <head>
        <?php include('./layouts/web/meta.php');?>
    </head>

    <body style="background: #fff;">

        <?php include('./layouts/page-loader.php');?>
        <div class="wrapper">
            <?php include('./layouts/web/top-menu.php');?>
            <section class="container" style="padding-top: 100px;">
                <div class="row">
                    <div class="col col-lg-12">
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading">Congratsulation!</h4>
                            <br>
                            <p>Hi <strong style="text-transform: uppercase;"><?php echo $name; ?></strong>, your reservation was successfuly submitted. </p>
                            <br>
                            <hr>
                            <p class="mb-0">
                                For your reference, please check your reservation info:
                            </p>
                            <br>
                            <p> Reservation No: <strong><?php echo $reservation_no; ?></strong>
                            <p> Check-in Date : <strong><?php echo $checkin_date; ?></strong>
                        </div>
                        <div>
                        <a href="./process/auth-logout.php">
				<strong style="margin-right: 10px;">Hi, <?php echo $_SESSION['s-name']; ?></strong>
				<span class="glyphicon glyphicon-log-out"></span> Logout?
			</a>
                        </div>
                    </div>
                </div>
            </section>
            <?php include('./layouts/scripts.php'); ?>
    </body>

</html>