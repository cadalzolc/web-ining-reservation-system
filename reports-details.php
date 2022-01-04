<?php 

session_start();

if (empty($_SESSION['s-id'])) {
	require_once("./includes/config.php");
    header('Location:' . BaseURL() . "login.php");
	exit;
}

include('./includes/conn.php');

$GLOBALS["active-page"] = "reports";

$date = $_GET['date'];
$res =  Execute("SELECT * FROM vw_trn_reservations WHERE date = '$date' AND status = 'G';");
$total = 0.00;

?>

<!DOCTYPE html>
<html lang="">
<?php include("./layouts/portal/head.php") ?>

<body>

    <?php include("./layouts/portal/menu.php") ?>
    <br />
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./dashboard.php">Home</a></li>
                <li class="breadcrumb-item"><a href="./reports.php">Reports</a></li>
                <li class="breadcrumb-item active" aria-current="page">Report Detail</li>
            </ol>
        </nav>
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div id="trans-table">
                <div style="font-weight: 600; font-size: 22px; margin-bottom: 15px;">
                    Sales Report Date: <?php echo $date; ?>
                    <button class="btn btn-primary" style="float: right;" onclick="display()">
                        <i class="fa fa-print"></i> Print
                    </button>
                </div>
                <table id="myTable-trans" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Aminity</th>
                            <th>Customer</th>
                            <th style="text-align: right;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $cnt =  1;
                            foreach($res as $t): 
                        ?>
                        <tr>
                            <td style="width: 10px;"><?= $cnt; ?></td>
                            <td><?= $t['aminity']; ?></td>
                            <td><?= $t['customer']; ?></td>
                            <td style="text-align: right;"><?= $t['amount']; ?></td>
                        </tr>
                        <?php 
                            $cnt++;
                            $total = $total + $t['amount'];
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