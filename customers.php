<?php 

session_start();

if (empty($_SESSION['s-id'])) {
	require_once("./includes/config.php");
    header('Location:' . BaseURL() . "login.php");
	exit;
}

include('./includes/conn.php');

$GLOBALS["active-page"] = "customers";

$res =  Execute("SELECT * FROM vw_trn_reservations;")
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
                            <td><?= $t['aminity']; ?></td>
                            <td><?= $t['amount']; ?></td>
                            <td><?= $t['no_units']; ?></td>
                            <td><?= $t['check_in']; ?></td>
                            <td style="padding: 3px;">
                                <a type="button" class="btn btn-success btn-xs" href="./customers-info.php?id=<?= $t['cs_id'];  ?>"
                                    style="height: 100% !important; width: 100%; line-height: 2;">View</a>
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

    <?php include('./layouts/portal/scripts.php'); ?>
    
    <script type="text/javascript">
        $(document).ready(function () {
            $('#myTable-trans').DataTable();
        });
    </script>
</body>

</html>