<?php

echo '
<div class="modal-dialog">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="form-title">ADD DISCOUNT</h1>
                    <form class="form-horizontal form-info" method="POST" onsubmit="return SaveDiscount(this);" style="margin-bottom: 10px;">
                        <div class="row" style="padding-bottom: 7px;">
                            <div class="col-sm-5">Description</div>
                            <div class="col-sm-7">
                                <input class="form-input" type="text" name="Name" value="" required=""/>
                            </div>
                        </div>
                       
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
';