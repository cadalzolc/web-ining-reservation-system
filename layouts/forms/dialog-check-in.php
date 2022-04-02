<?php 

include('../../includes/conn.php');

date_default_timezone_set('Asia/Manila');

$id = $_GET['ref'];
$date = date('Y-m-d g:ia');

$res_info = Execute("CALL sp_get_reservation_by_id($id);");
$info = mysqli_fetch_assoc($res_info);

 echo '
    <div class="modal-dialog modal-dialog-centered " role="document">

        <form class="modal-content modal-small small-box" method="POST" onsubmit="return OnTransactionSubmit(this);" data-busy="#MdlAdd" action="./process/check-in.php">
            <input type="hidden" name="Id" value="'. $id .'" />
            <div class="modal-body" style="overflow: hidden;">
                <div style="display: block;">
                    <strong style="text-transform: uppercase; font-size: 22px;">'. $info['customer'] .'</strong>
                </div>
                <br>
                <div style="display: block;">
                    Date: <br> <strong>'. $date .'</strong>
                </div>
                <br>
                <div style="display: block;">
                    Reserved Unit : <br> <strong>'.  $info['aminity'] .'</strong>
                </div>
                <div style="display: block;">
                    <div style="float: right;">
                        <button type="submit" class="btn btn-primary" >Check-In</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="OnCloseClick()">Cancel</button>
                    </div>
                </div>
            </div>
            <div id="MdlAdd" class="overlay">
                <div class="spinner-border text-success" role="status">
                    <span class="visually-hidden"></span>
                </div>
            </div>
        </div>
       
    </div>
 ';

?>