<?php

echo '
<div class="modal-dialog">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="form-title">ADD AMENITY</h1>
                    <form class="form-horizontal form-info" method="POST" onsubmit="return SaveAminityType(this);" style="margin-bottom: 10px;">
                        <div class="row" style="padding-bottom: 7px;">
                            <div class="col-sm-5">Name</div>
                            <div class="col-sm-7">
                                <input class="form-input" type="text" name="Name" value="" required=""/>
                            </div>
                        </div>
                        <div class="row" style="padding-bottom: 7px;">
                            <div class="col-sm-5">Rate</div>
                            <div class="col-sm-7"">
                                <input  class="form-input" type="number" name="Rate" value="" required=""
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