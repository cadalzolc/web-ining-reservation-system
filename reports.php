<?php 
ini_set('session.save_path', './temp');
session_start();

if (empty($_SESSION['s-id'])) {
	require_once("./includes/config.php");
    header('Location:' . BaseURL() . "login.php");
	exit;
}

include('./includes/conn.php');

$GLOBALS["active-page"] = "reports";

$res =  Execute("SELECT * FROM vw_rpt_reservation;");
$total = 0.00;

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
                <div style="font-weight: 600; font-size: 22px; margin-bottom: 15px;">
                    Sales Summary:
                    <button class="btn btn-primary" style="float: right;" onclick="display()">
                        <i class="fa fa-print"></i> Print
                    </button>
                </div>
                <table id="myTable-trans" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th style="width: 35px !important;"></th>
                            <th>Date</th>
                            <th style="text-align: right;">Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $cnt =  1;
                            foreach($res as $t): 
                        ?>
                        <tr>
                            <td style="width: 10px;"><?= $cnt; ?></td>
                            <td style="padding: 3px;">
                                <a href="./reports-details.php?date=<?= $t['date']; ?>" class="btn btn-success btn-xs"
                                    style="height: 100% !important; width: 100%; line-height: 2;">View Details</a>
                            </td>
                            <td><?= $t['date']; ?></td>
                            <td style="text-align: right;"><?= $t['sales']; ?></td>
                        </tr>
                        <?php 
                            $cnt++;
                            $total = $total + $t['sales'];
                            endforeach; ?>
                    </tbody>
                    <tfoot>
                        <td colspan="4" style="font-weight: bold; text-align: right;">Total : <?php echo number_format($total, 2, '.', ','); ?> </td>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
    <div id="Olm" class="overlay-modal"></div>
   <?php include('./layouts/portal/scripts.php'); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#myTable-trans').DataTable();
        });
        function display() {
            window.print();
         }
    </script>
</body>

</html>