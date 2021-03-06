<?php

include('../../includes/conn.php');

$id = $_GET["id"];

$res_info = Execute("SELECT * FROM typ_discount WHERE id=$id;");

$info = mysqli_fetch_assoc($res_info);


echo '
<div class="modal-dialog">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="form-title">Update Discount</h1>
                    <form class="form-horizontal form-info" method="POST" onsubmit="return SaveDiscountUpdate(this);" style="margin-bottom: 10px;">
                        <div class="row" style="padding-bottom: 7px;">
                            <div class="col-sm-5">Description</div>
                            <div class="col-sm-7">
                                <input class="form-input" type="text" name="Name" value="' . $info["name"] . '" required=""/>
                            </div>
                        </div>
                        <div class="row" style="padding-bottom: 7px;">
                            <div class="col-sm-5">Percent</div>
                            <div class="col-sm-7"">
                                <input  class="form-input" type="number" name="Percent" value="' . $info["percent"] * 100 . '" required="" min="1" max="100"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" style="float: right; padding: 5px 15px;">
                                <button type="submit" class="btn btn-primary" style="font-size: 12px;">Save</button>
                                <button type="button" class="btn btn-secondary" data-close="" style="font-size: 12px;">Close</button>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="'. $id  .'" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
';