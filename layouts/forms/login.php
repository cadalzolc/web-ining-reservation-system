<?php

$DT_AID = $_GET['AID'];
$DT_CheckIn = $_GET['Check-in'];
$DT_Units = $_GET['Units'];
$DT_Person = $_GET['Person'];

echo '
<div class="modal-dialog" method="POST" ">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6" style="border-right: 3px solid #337ab7;">
                    <h1 class="form-title">Dont have an account yet?</h1>
                    <h3 class="form-title-child" style="margin-bottom: 10px;">Customer Registration</h3>
                    <form class="form-horizontal form-info" method="POST" onsubmit="return OnFormRegister(this);" style="margin-bottom: 10px;">
                        <div class="row" style="padding-bottom: 7px;">
                            <div class="col-sm-5">First Name</div>
                            <div class="col-sm-7">
                                <input class="form-input" type="text" name="NameF" value="" required=""/>
                            </div>
                        </div>
                        <div class="row" style="padding-bottom: 7px;">
                            <div class="col-sm-5">Middle Name</div>
                            <div class="col-sm-7"">
                                <input  class="form-input" type="text" name="NameM" value="" required=""/>
                            </div>
                        </div>
                        <div class="row" style="padding-bottom: 7px;">
                            <div class="col-sm-5">Last Name</div>
                            <div class="col-sm-7"">
                                <input  class="form-input" type="text" name="NameL" value="" required=""/>
                            </div>
                        </div>
                        <div class="row" style="padding-bottom: 7px;">
                            <div class="col-sm-5">Gender</div>
                            <div class="col-sm-7"">
                                <select  class="form-input" name="Gender" required="">
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="padding-bottom: 7px;">
                            <div class="col-sm-5">Age</div>
                            <div class="col-sm-7"">
                                <input  class="form-input" type="number" min="0" max="150" name="Age" value="" required=""/>
                            </div>
                        </div>
                        <div class="row" style="padding-bottom: 7px;">
                            <div class="col-sm-5">Contact</div>
                            <div class="col-sm-7"">
                                <input  class="form-input" type="text" name="Contact" value="" required=""/>
                            </div>
                        </div>
                        <div class="row" style="padding-bottom: 7px;">
                            <div class="col-sm-5">Address</div>
                            <div class="col-sm-7"">
                                <input  class="form-input" type="text" name="Address" value="" required=""/>
                            </div>
                        </div>
                        <div class="row" style="padding-bottom: 7px;">
                            <div class="col-sm-5">Username</div>
                            <div class="col-sm-7"">
                                <input  class="form-input" type="text" name="Username" value="" required=""/>
                            </div>
                        </div>
                        <div class="row" style="padding-bottom: 7px;">
                            <div class="col-sm-5">Password</div>
                            <div class="col-sm-7"">
                                <input  class="form-input" type="text" name="Password" value="" required=""/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" style=" padding: 5px 15px;">
                                <button type="submit" class="btn btn-primary" style="font-size: 12px; float: right;">Submit</button>
                            </div>
                        </div>
                        <input type="hidden" name="T1" value="'. $DT_AID .'" />
                        <input type="hidden" name="T2" value="'. $DT_CheckIn .'" />
                        <input type="hidden" name="T3" value="'. $DT_Units .'" />
                        <input type="hidden" name="T4" value="'. $DT_Person .'" />
                    </form>
                </div>
                <div class="col-sm-6">
                    <h1 class="form-title">Already registered?</h1>
                    <h3 class="form-title-child" style="margin-bottom: 10px;">Customer Login</h3>
                    <form class="form-horizontal form-info" method="POST" onsubmit="return OnFormLogin(this);" style="margin-bottom: 10px;">
                        <div class="row" style="padding-bottom: 7px;">
                            <div class="col-sm-5">Username</div>
                            <div class="col-sm-7">
                                <input class="form-input" type="text" name="Username" value="" required=""/>
                            </div>
                        </div>
                        <div class="row" style="padding-bottom: 7px;">
                            <div class="col-sm-5">Password</div>
                            <div class="col-sm-7"">
                                <input  class="form-input" type="password" name="Password" value="" required=""/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" style="float: right; padding: 5px 15px;">
                                <button type="submit" class="btn btn-primary" style="font-size: 12px;">Login</button>
                                <button type="button" class="btn btn-secondary" data-close="" style="font-size: 12px;">Close</button>
                            </div>
                        </div>
                        <input type="hidden" name="T1" value="'. $DT_AID .'" />
                        <input type="hidden" name="T2" value="'. $DT_CheckIn .'" />
                        <input type="hidden" name="T3" value="'. $DT_Units .'" />
                        <input type="hidden" name="T4" value="'. $DT_Person .'" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
';