<?php

include('../../includes/conn.php');

$RV_ID = $_GET['uid'];

$res_info = Execute("CALL sp_get_reservation_by_id($RV_ID);");
$info = mysqli_fetch_assoc($res_info);

echo $RV_ID  .'
<div class="modal-dialog">
    <div class="panel panel-danger">
        <div class="panel-body">
            <h3 class="form-title-child" style="display: flex; margin-bottom: 10px; background: #5cb85c; padding: 15px;">Cancel Reservation</h3>
            <form class="form-horizontal form-info" method="POST" onsubmit="return OnFormSubmitCancel(this);" style="margin-bottom: 10px;">
                <div class="row" style="margin-bottom: 5px;">
                   <div class="col-lg-12" >
                    <h1>Are you sure you want to cancel this transaction?</h1>
                    <p>RS' . ($info['id'] + 1000) . ' - ' . $info['customer'] . '</p>
                    <input type="hidden" id="RevID" name="RevID" value="'. $info["id"]  .'"/>
                    <input type="hidden" id="RevCS" name="RevCS" value="'. $info["cs_id"]  .'"/>
                    <input type="hidden" id="RevAM" name="RevAM" value="'. $info["am_id"]  .'"/>
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