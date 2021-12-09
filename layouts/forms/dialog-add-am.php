<?php

include('../../includes/conn.php');

echo '
<div class="modal-dialog">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="form-title">Add Aminity</h1>
                    <form class="form-horizontal form-info" method="POST" onsubmit="return AddAminity(this);" style="margin-bottom: 10px;">
                        <div class="row" style="padding-bottom: 7px;">
                            <div class="col-sm-5">Description</div>
                            <div class="col-sm-7">
                                <input class="form-input" type="text" name="Name" value=""  required=""/>
                            </div>
                            <div class="col-sm-7">
                                <input class="form-input" type="number" name="rate" value="" required=""/>
                            </div>
                            <div class="col-sm-7">
                            <input class="form-input" type="number" name="person limit" value="" required=""/>
                        </div>

                        <div class="col-sm-7">
                        <input class="form-input" type="number" name="units" value="" required=""/>
                    </div>
                    <div class="col-sm-7">
                        <input class="form-input" type="number" name="total" value="" required=""/>
                    </div>
                        </div>
                        <div class="row">
                        <div class="col-lg-12" style=" padding: 5px 15px;">
                        <button type="submit" class="btn btn-primary" style="font-size: 12px; float: right;">Submit</button>
                    </div>
                </div>
                <input type="hidden" name="T1" value="'. $DT_ID .'" />
                <input type="hidden" name="T2" value="'. $DT_RATE .'" />
                <input type="hidden" name="T3" value="'. $DT_Person .'" />
                <input type="hidden" name="T4" value="'. $DT_Units .'" />
                <input type="hidden" name="T4" value="'. $DT_total.'" />
            </form>
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