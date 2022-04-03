<?php 
ini_set('session.save_path', './temp');
session_start();

if (empty($_SESSION['s-id'])) {
	require_once("./includes/config.php");
    header('Location:' . BaseURL() . "login.php");
	exit;
}

include('./includes/conn.php');

$GLOBALS["active-page"] = "customer-info";
$id = $_GET['id'];
$res =  Execute("SELECT * FROM vw_trn_reservations where cs_id = $id;")
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
            <div id="trans-table">
                <table id="myTable-trans" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th style="width: 60px;">Booked Id</th>
                            <th>Date</th>
                            <th>Customer</th>              
                            <th>Aminity</th>
                            <th>Amount</th>
                            <th>Units</th>
                            <th>Check-In</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $cnt =  1;
                            foreach($res as $t): 
                        ?>
                        <tr>

                            <td><?= $cnt; ?></td>
                            <td>RS<?php echo 1000 +  $t['id'];?></td>
                            <td><?= $t['date']; ?></td>
                            <td><?= $t['customer']; ?></td>
                            <td><?= $t['aminity']; ?></td>
                            <td><?= $t['amount']; ?></td>
                            <td><?= $t['no_units']; ?></td>
                            <td><?= $t['check_in']; ?></td>
                        </tr>
                        <?php 
                            $cnt++;
                            endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>

    <?php include('./layouts/portal/scripts.php'); ?>                   
</body>

</html>