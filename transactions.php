<?php 
ini_set('session.save_path', './temp');
session_start();

if (empty($_SESSION['s-id'])) {
	require_once("./includes/config.php");
    header('Location:' . BaseURL() . "login.php");
	exit;
}

include('./includes/conn.php');

$GLOBALS["active-page"] = "transactions";

$res =  Execute("CALL sp_get_reservation_by_status('G');")


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
            <div>
         
            </div>
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
                            <th>Arrival</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
		                    $cnt =  1;
		                    foreach($res as $t): ?>
                        <tr>

                            <td><?= $cnt; ?></td>
                            <td>RS<?php echo 1000 +  $t['id'];?></td>
                            <td><?= $t['date']; ?></td>
                            <td><?= $t['customer']; ?></td>       
                            <td><?= $t['aminity']; ?></td>
                            <td><?= $t['amount']; ?></td>
                            <td><?= $t['no_units']; ?></td>
                            <td><?= $t['check_in']; ?></td>
                            <td>
                                <?php 
                                    if ($t['date_in'] == ""){
                                        ?>
                                            <a class="btn btn-success" href="#" onclick="OnTransactionClick(this)" data-route="./layouts/forms/dialog-check-in.php?ref=<?= $t['id']; ?>">Check In</a>
                                        <?php
                                    }else{
                                        $dt = date("Y-m-d g:ia", strtotime($t['date_in']));
                                        echo $dt;
                                    }
                                ?>
                            </td>
                            <td>
                                <?php 
                                    if ($t['date_in'] != "" && $t['date_out'] == ""){
                                        ?>
                                            <a class="btn btn-success" href="#" onclick="OnTransactionClick(this)" data-route="./layouts/forms/dialog-check-out.php?ref=<?= $t['id']; ?>">Check Out</a>
                                        <?php
                                    }else {
                                        if ($t['date_out'] !=""){
                                            $dt = date("Y-m-d g:ia", strtotime($t['date_out']));
                                            echo $dt;
                                        }
                                    }
                                ?>
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
    <div id="Olm" class="overlay-modal"></div>
    <div id="DV000" class="modal modal-default"></div>
    <script type="text/javascript" src="./assets/js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="./assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="./assets/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="./assets/js/toastr.min.js"></script>
    <script type="text/javascript" src="./assets/js-custom/transaction.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#myTable-trans').DataTable();
        });
        $(document).on('click', 'button[data-close]', function () {
            $('#Olm').hide();
        });
    </script>
</body>

</html>

