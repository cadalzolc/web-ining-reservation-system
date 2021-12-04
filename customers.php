<?php 

session_start();

if (empty($_SESSION['s-id'])) {
	require_once("./includes/config.php");
    header('Location:' . BaseURL() . "login.php");
	exit;
}

include('./includes/conn.php');

$GLOBALS["active-page"] = "maintenance";

$res =  Execute("SELECT * FROM medallion.vw_trn_reservations;")
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
                            <th>Pack</th>
                            <th>Aminity</th>
                            <th>Amount</th>
                            <th>Units</th>
                            <th>Check-In</th>
                            <th></th>
                            <th style="width: 35px !important;"></th>
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
                            <td class="text-center"><?= $t['no_persons']; ?></td>
                            <td><?= $t['aminity']; ?></td>
                            <td><?= $t['amount']; ?></td>
                            <td><?= $t['no_units']; ?></td>
                            <td><?= $t['check_in']; ?></td>
                            <td style="padding: 3px;">
                                <button type="button" class="btn btn-success btn-xs"
                                    style="height: 100% !important; width: 100%; line-height: 2;">View</button>
                            </td>
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

    <script type="text/javascript" src="./assets/js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="./assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="./assets/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#myTable-trans').DataTable();
        });
    </script>
</body>

</html>