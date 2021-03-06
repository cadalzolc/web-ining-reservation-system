<?php

include('../../includes/conn.php');

$RV_ID = $_GET['uid'];

$res_info = Execute("CALL sp_get_reservation_by_id($RV_ID);");
$info = mysqli_fetch_assoc($res_info);

echo $RV_ID  .'
<div class="modal-dialog">
    <div class="panel panel-default">
        <div class="panel-body">
            <h3 class="form-title-child" style="display: flex; margin-bottom: 10px; background: #5cb85c; padding: 15px;">Confirm Pay Reservation</h3>
            <form class="form-horizontal form-info" method="POST" onsubmit="return OnFormSubmitPay(this);" style="margin-bottom: 10px;">
                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-sm-2">No:</div>
                    <div class="col-sm-4">
                        <input type="hidden" id="RevID" name="RevID" value="'. $info["id"]  .'"/>
                        <input type="hidden" id="RevCS" name="RevCS" value="'. $info["cs_id"]  .'"/>
                        <input type="hidden" id="RevAM" name="RevAM" value="'. $info["am_id"]  .'"/>
                        <input class="form-input" type="text" id="RevNo" name="RevNo" value="RS'. (1000 + $info["id"])  .'" readonly="" style=" width: 100%;"/>
                    </div>
                    <div class="col-sm-2">Date:</div>
                    <div class="col-sm-4">
                        <input class="form-input" type="Date" name="RevDate" value="'. $info["date"] .'" readonly="" style=" width: 100%;" placeholde="yyyy-mm-dd">
                    </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-sm-2">Aminity:</div>
                    <div class="col-sm-4">
                        <input class="form-input" type="text" name="Aminity" value="'. $info["aminity"] .'" style=" width: 100%;"/>
                    </div>
                    <div class="col-sm-2">Total:</div>
                    <div class="col-sm-4">
                        <input class="form-input" type="text" id="Total" name="Total" value="'. $info["amount"] .'" readonly="" style=" width: 100%; text-align: right; font-weight: bold; color: #d9534f;" placeholde="yyyy-mm-dd">
                    </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-sm-2">Customer:</div>
                    <div class="col-sm-10">
                        <input class="form-input" type="text" name="Customer" value="'. $info["customer"] .'" style=" width: 100%;"/>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 5px; display: block;">
                    <div class="col-lg-12" style="float: right; padding: 5px 15px;">
                        <button type="submit" class="btn btn-primary" style="font-size: 12px;">Confirm</button>
                        <button type="button" class="btn btn-secondary" data-close="" style="font-size: 12px;">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
';