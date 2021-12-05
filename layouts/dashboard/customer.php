<?php 

include_once("./includes/conn.php");

$id =  $_SESSION["s-id"];
$res =  Execute("CALL sp_get_customer_reservation($id);");

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3"><h3>My Reservations</h3></div>
        <div class="col-md-9">
        <div id="trans-table">
                <table id="myTable-trans" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Check-In</th>
                            <th>Amenity Type</th>
                            <th>Units</th>
                            <th>Persons</th>
                            <th>Amount</th>
                            <th>Status</th>
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
                            <td><?= $t['check_in']; ?></td>
                            <td><?= $t['aminity']; ?></td>
                            <td><?= $t['no_units']; ?></td>
                            <td><?= $t['no_persons']; ?></td>
                            <td><?= $t['amount']; ?></td>
                            <td><?= $t['status']; ?></td>
                           
                           
                        </tr>
                        <?php 
                            $cnt++;
                            endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
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