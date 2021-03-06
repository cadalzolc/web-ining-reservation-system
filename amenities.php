<?php
include('./includes/conn.php');
include('./includes/config.php');

ini_set('session.save_path', './temp');
session_start();

$msg = "";
$date = date('Y-m-d');
$id = $_GET['id'];
$req_date = $_GET['date'];

if (!empty($req_date)) {
    $date = $req_date;
}

$results = Execute("CALL sp_get_aminity_info_today($id, '$date');");

?>

<!DOCTYPE html>
<html>

<head>
    <?php include('./layouts/web/meta.php');?>
</head>

<body>
    <?php include('./layouts/page-loader.php');?>
    <div class="wrapper">
        <?php include('./layouts/web/top-menu.php');?>
        <section class="main-start">
            <div class="container" style="padding-top: 30px;">

                <?php 
                
                if ($results) {

                $row = mysqli_fetch_array($results);

                ?>
                <div class="row col-mb-30">
                    <div class="col-sm-6 col-md-6 col-lg-6  min-vh-50 min-vh-lg-75"
                        style="background: url('./uploads/img/<?php echo $row['photo']; ?>') no-repeat center center; background-size: cover;">
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-body">

                                <form class="form-horizontal form-info" onsubmit="return OnFormReserve(this);">

                                    <div class="row" style="padding-bottom: 7px;">
                                        <div class="col-sm-4">Name</div>
                                        <div class="col-sm-8"><?php echo $row['name']; ?></div>
                                    </div>
                                    <div class="row" style="padding-bottom: 7px;">
                                        <div class="col-sm-4">Rates</div>
                                        <div class="col-sm-8" data-rate="<?php echo $row['rates']; ?>">
                                            <?php echo $row['rates']; ?></div>
                                    </div>
                                    <div class="row" style="padding-bottom: 7px;">
                                        <div class="col-sm-4">Person Limit</div>
                                        <div class="col-sm-8"><?php echo $row['person_limit']; ?></div>
                                    </div>
                                    <div class="row" style="padding-bottom: 7px;">
                                        <div class="col-sm-4">Check-In Date <?php echo $date; ?></div>
                                        <div class="col-sm-8">
                                            <input type="date" id="CheckIn" name="Check-in" class="text-box" min="<?php echo date('Y-m-d'); ?>"
                                                value="<?php echo $date; ?>" placeholder="YYYY-MM-DD" />
                                        </div>
                                    </div>
                                    <div class="row info-warning">
                                        <div class="col-sm-12"><span><?php echo $row['available']; ?></span> available
                                            units by Check-in Date (<?php echo $date; ?>)</div>

                                    </div>
                                    <div class="row" style="padding-bottom: 7px;">
                                        <div class="col-sm-4">Units</div>
                                        <div class="col-sm-8">
                                            <select class="text-box" id="Units" name="Units">
                                                <?php  
                                                for ($x = 1; $x <= $row['available']; $x++) {
                                                    if ($x == 1) {
                                                        echo '<option selected value="'. $x .'">'. $x .'</option>';
                                                    }else {
                                                        echo '<option value="'. $x .'">'. $x .'</option>';
                                                    }
                                                }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-bottom: 7px;">
                                        <div class="col-sm-4">Total</div>
                                        <div class="col-sm-8" data-total="0">
                                            <?php
                                            if ($row['available'] >= 1) {
                                                echo $row['rates'] * 1;
                                            }else {
                                                echo "0";
                                            }
                                        ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <?php 
                                        
                                            if ($row['available'] <= 0) {
                                        ?>
                                            <div class="col-sm-12" style="text-align: right;">
                                               <p style="color: #d9534f; font-weight: 700;">Please select a new date!</p>
                                            </div>
                                        <?php
                                            } else {
                                        ?>
                                            <div class="col-sm-12" style="text-align: right;">
                                                <button type="submit" class="btn btn-primary" name="btn-add"
                                                    style="margin-left: 5px;">Reserved</button>
                                            </div>
                                        <?php
                                            }
                                        
                                        ?>
                                    </div>
                                    <input type="hidden" name="AID" value="<?php echo $row['id']; ?>" />
                                </form>
                                <?php
                } else {
                    echo "No record was found!";
                }
                
                ?>
            </div>
            <input type="hidden" id="RefURL" value="<?php echo BaseURL() . 'amenities.php?id=' . $id ?>" />
        </section>


        <div id="Olm" class="overlay-modal"></div>

        <?php 
            include('./layouts/web/footer.php');
            include('./layouts/scripts.php');
            ?>


        <script>
            $('#Units').bind('change', function () {
                let rate = $('div[data-rate]').data('rate');
                let total = rate * $(this).val();
                $('div[data-total]').html(total);
            });


            $('#CheckIn').on("change", function() {
                window.location.href = $("#RefURL").val() + "&date=" + $(this).val();
            });

            function OnFormReserve(frm) {
                $.get('./includes/online.php', function(data) {
                    if (data == 0) {
                        $.get('./layouts/forms/dialog-reserve.php', $(frm).serialize(), function(data) {
                            $('#Olm').empty();
                            $('#Olm').append(data);
                            $('#Olm').show();
                        });
                    }else {
                        OnReserveSubmit(frm);
                    }
                });
                return false;
            }

            function OnFormLogin(frm) {
                $.post('./process/form-login.php', $(frm).serialize(), function(data) {
                    if (data.success) {
                        toastr.success(data.message);
                        window.location.href=  "<?php echo BaseURL(); ?>thanks.php?trn=" + data.results.trn + "&date=" + data.results.date + "&name=" + data.results.name;
                    }else{
                        toastr.error(data.message);
                    }
                });
                return false;
            }

            function OnFormRegister(frm) {
                $.post('./process/form-register.php', $(frm).serialize(), function(data) {
                    if (data.success) {
                        toastr.success(data.message);
                        window.location.href=  "<?php echo BaseURL(); ?>thanks.php?trn=" + data.results.trn + "&date=" + data.results.date + "&name=" + data.results.name;
                    }else{
                        toastr.error(data.message);
                    }
                });
                return false;
            }

            function OnReserveSubmit(frm) {
                $.post('./process/form-reserve.php', $(frm).serialize(), function(data) {
                    if (data.success) {
                        toastr.success(data.message);
                        window.location.href=  "<?php echo BaseURL(); ?>thanks.php?trn=" + data.results.trn + "&date=" + data.results.date + "&name=" + data.results.name;
                    }else{
                        toastr.error(data.message);
                    }
                });
                return false;
            }


            $(document).on('click', 'button[data-close]', function(){ 
                $('#Olm').hide();
            }); 
    

        </script>

</body>

</html>