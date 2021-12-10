<?php

include('../../includes/conn.php');

$RV_ID = $_GET['uid'];

$res_info = Execute("CALL sp_get_reservation_by_id($RV_ID);");
$info = mysqli_fetch_assoc($res_info);

$res = Execute("SELECT * FROM typ_discount;");
$opt_discount = "";

foreach($res as $row):
    $opt_discount = $opt_discount . '<option data-percent="' . $row["percent"] .'" value="' . $row["id"] .'">' . $row["name"] .'</option>';
endforeach;

$good = $info['available'] >= $info['no_units'];

$btn = "";
$msg = "";
if ($good == true) {
    $btn = '<button type="submit" name="submit" value="good" data-submit="good" class="btn btn-primary" style="font-size: 12px;">Confirm Reservation</button>';
}else {
    $btn = '<button type="submit" name="submit" value="notify" data-submit="notify" class="btn btn-primary" style="font-size: 12px;">Notify Customer</button>';
    $msg = "Sorry, this reservation cannot be served, the reserved unit count is greater than available stock (" . $info['available'] .").";
}


$opt_units = "";

for($i = 1; $i <= $info['available']; $i++) {
    if ($info['no_units'] == $i) {
        $opt_units = $opt_units . '<option selected value="'. $i .'">'. $i .'</option>';
    } else {
        $opt_units = $opt_units . '<option value="'. $i .'">'. $i .'</option>';
    }
}

echo $RV_ID  .'
<div class="modal-dialog">
    <div class="panel panel-default">
        <div class="panel-body">
            <h3 class="form-title-child" style="margin-bottom: 10px; display: flex;">Reservation Details</h3>
            <form class="form-horizontal form-info" method="POST" onsubmit="return OnFormSubmitNotify(this);" style="margin-bottom: 10px;">
                <input type="hidden" name="original" value="' . $info['no_units'] . '" />
                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-sm-2">No:</div>
                    <div class="col-sm-4">
                        <input class="form-input" type="text" name="RevNo" value="'. $info["id"] .'" readonly="" style=" width: 100%;"/>
                    </div>
                    <div class="col-sm-2">Date:</div>
                    <div class="col-sm-4">
                        <input class="form-input" type="Date" name="RevDate" value="'. $info["date"] .'" readonly="" style=" width: 100%;" placeholde="yyyy-mm-dd">
                    </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-sm-2">Check In:</div>
                        <div class="col-sm-4">
                            <input class="form-input" type="date" name="CheckIn" value="'. $info["check_in"] .'" style=" width: 100%;" placeholde="yyyy-mm-dd">
                        </div>
                    <div class="col-sm-2">Units:</div>
                    <div class="col-sm-4">
                    <input class="form-input" value="'. $info["no_units"] .'" style=" width: 70px; text-align: center; color: #2e6da4; font-weight: bold;">
                        <select class="form-input" type="Units" name="RevUnits" required="" style=" width: 95px; padding: 4px;">'. $opt_units  .'</select>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-sm-2">Aminity:</div>
                    <div class="col-sm-4">
                        <input class="form-input" type="text" name="Aminity" value="'. $info["aminity"] .'" style=" width: 100%;"/>
                    </div>
                    <div class="col-sm-2">Amount:</div>
                    <div class="col-sm-4">
                        <input class="form-input" type="text" id="Amount" name="Amount" value="'. $info["amount"] .'" style=" width: 100%;" placeholde="yyyy-mm-dd">
                    </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-sm-2">Customer:</div>
                    <div class="col-sm-4">
                        <input class="form-input" type="text" name="Customer" value="'. $info["customer"] .'" style=" width: 100%;"/>
                    </div>
                    <div class="col-sm-2">Contact:</div>
                    <div class="col-sm-4">
                        <input class="form-input" type="text" name="Contact" value="'. $info["contact"] .'" style=" width: 100%;" placeholde="yyyy-mm-dd">
                    </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-sm-2">Address:</div>
                    <div class="col-sm-10">
                        <input class="form-input" type="text" name="Address" value="'. $info["address"] .'" style=" width: 100%;"/>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 5px;"> 
                    <div class="col-sm-2">Discount:</div>
                    <div class="col-sm-4">
                        <select class="form-input" data-total="" id="Discount" name="Discount" required="" style="width: 100%; height: 26px;">' . $opt_discount . '</select>
                    </div>
                    <div class="col-sm-2">Total:</div>
                    <div class="col-sm-4">
                        <input class="form-input" type="text" id="Total" name="Total" value="'. $info["amount"] .'" readonly="" style=" width: 100%; text-align: right; font-weight: bold; color: #d9534f;" placeholde="yyyy-mm-dd">
                    </div>
                </div>
                <div style="color: #bf2222;">' . $msg . '</div>
                <div class="row" style="margin-bottom: 5px; display: block;">
                    <div class="col-lg-12" style="float: right; padding: 5px 15px;">
                        ' . $btn . '
                        <button type="submit" name="submit" data-submit="cancel" value="cancel" class="btn btn-danger" style="font-size: 12px;">Cancel Reservation</button>
                        <button type="button" class="btn btn-secondary" data-close="" style="font-size: 12px;">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
';