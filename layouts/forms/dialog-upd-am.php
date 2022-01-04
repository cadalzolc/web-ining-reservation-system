<?php

include('../../includes/conn.php');

$id = $_GET["id"];

$res_info = Execute("SELECT * FROM lst_aminities WHERE id=$id;");

$info = mysqli_fetch_assoc($res_info);

$res = Execute("SELECT * FROM typ_aminities;");
$typ = "";

foreach($res as $row):
    if($row["id"] == $info["type_id"]) {
        $typ = $typ . '<option selected value="' . $row["id"] .'">' . $row["name"] .'</option>';
    }else
    {
        $typ = $typ . '<option value="' . $row["id"] .'">' . $row["name"] .'</option>';
    }
endforeach;

echo '
<div class="modal-dialog">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="form-title">Update Amenity</h1>
                    <form class="form-horizontal form-info" method="POST" onsubmit="return SaveAmenityUpdate(this);" style="margin-bottom: 10px;">
                        <input type="hidden" name="Id" value="'. $id .'" />
                        <div class="row" style="padding-bottom: 7px;">
                            <div class="col-sm-5">Aminity type</div>
                            <div class="col-sm-7">
                                <input class="form-input" type="text" name="Name" value="' . $info["name"] . '" required=""/>
                            </div>
                        </div>
                        <div class="row" style="padding-bottom: 7px;">
                        <div class="col-sm-5">Capacity</div>
                        <div class="col-sm-7">
                            <input class="form-input" type="text" name="Capacity" value="' . $info["person_limit"] . '" required=""/>
                        </div>
                    </div>
                        <div class="row" style="padding-bottom: 7px;">
                            <div class="col-sm-5">Available</div>
                            <div class="col-sm-7">
                                <input class="form-input" type="text" name="Available" value="' . $info["unit"] . '" required=""/>
                            </div>
                        </div>
                      
                        <div class="row" style="padding-bottom: 7px;">
                            <div class="col-sm-5">Price</div>
                            <div class="col-sm-7">
                                <input class="form-input" type="text" name="Rates" value="' . $info["rates"] . '" required=""/>
                            </div>
                        </div>
                        <div  class="row" style="padding-bottom: 7px;">
                            <div class="col-sm-5">Type</div>
                            <div class="col-sm-7">
                                <select class="text-box" type="text" name="Type" value="" required="" style="padding: 4px; width: 185px !important;">
                                    ' .$typ . '
                                </select>
                            </div>
                        </div>                      
                        <div class="row">
                            <div class="col-lg-12" style="float: right; padding: 5px 15px;">
                                <button type="submit" class="btn btn-primary" style="font-size: 12px;">Update</button>
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