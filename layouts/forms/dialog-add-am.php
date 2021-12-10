<?php

include('../../includes/conn.php');

$res = Execute("SELECT * FROM typ_aminities;");
$typ = "";

foreach($res as $row):
    $typ = $typ . '<option value="' . $row["id"] .'">' . $row["name"] .'</option>';
endforeach;

echo '
<div class="modal-dialog">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="form-title">ADD Item</h1>
                    <form class="form-horizontal form-info" method="POST" onsubmit="return SaveAmenityAdd(this);" style="margin-bottom: 10px;">
                        <div class="row" style="padding-bottom: 7px;">
                            <div class="col-sm-3">Aminity Name</div>
                            <div class="col-sm-9">
                                <input class="form-input" type="text" name="name" value="" required="" style="padding: 4px; width: 185px !important;"/>
                            </div>
                        </div>
                        <div class="row" style="padding-bottom: 7px;">
                            <div class="col-sm-3">Rate</div>
                            <div class="col-sm-9">
                                <input class="text-box" type="number" name="rate" value="" required="" min="50" max="99999" style="padding: 4px; width: 185px !important;"/>
                            </div>
                        </div>
                        <div  class="row" style="padding-bottom: 7px;">
                            <div class="col-sm-3">Capacity</div>
                            <div class="col-sm-9">
                                <input class="text-box" type="number" name="capacity" value="" required="" min="1" max="100" style="padding: 4px; width: 185px !important;"/>
                            </div>
                        </div>
                        <div  class="row" style="padding-bottom: 7px;">
                            <div class="col-sm-3">Available</div>
                            <div class="col-sm-9">
                                <input class="text-box" type="number" name="available" value="" required="" style="padding: 4px; width: 185px !important;" min="1" max="100"/>
                            </div>
                        </div>
                        <div  class="row" style="padding-bottom: 7px;">
                            <div class="col-sm-3">Type</div>
                            <div class="col-sm-9">
                                <select class="text-box" type="text" name="type" value="" required="" style="padding: 4px; width: 185px !important;">
                                    ' .$typ . '
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" style="float: right; padding: 5px 15px;">
                                <button type="submit" class="btn btn-primary" style="font-size: 12px;">Save</button>
                                <button type="button" class="btn btn-secondary" data-close="" style="font-size: 12px;">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
';