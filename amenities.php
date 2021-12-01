<?php
include('./includes/conn.php');

$id = $_GET['id'];
$date= date('Y-m-d');
$msg = "";
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

                                <form class="form-horizontal form-info" role="form" id="form-login"
                                    action="/medallion/admin/indexClient.php" method="POST">

                                    <div class="row" style="padding-bottom: 7px;">
                                        <div class="col-sm-4">Name</div>
                                        <div class="col-sm-8"><?php echo $row['name']; ?></div>
                                    </div>
                                    <div class="row" style="padding-bottom: 7px;">
                                        <div class="col-sm-4">Rates</div>
                                        <div class="col-sm-8" data-rate="<?php echo $row['rates']; ?>"><?php echo $row['rates']; ?></div>
                                    </div>
                                    <div class="row" style="padding-bottom: 7px;">
                                        <div class="col-sm-4">Check-In Date</div>
                                        <div class="col-sm-8">
                                            <input type="date" class="text-box" min="<?php echo $date; ?>" value="<?php echo $date; ?>"
                                                placeholder="YYYY-MM-DD" />
                                        </div>
                                    </div>
                                    <div class="row info-warning">
                                        <div class="col-sm-12"><span><?php echo $row['available']; ?></span> available units by Check-in Date (<?php echo $date; ?>)</div>

                                    </div>
                                    <div class="row" style="padding-bottom: 7px;">
                                        <div class="col-sm-4">Units</div>
                                        <div class="col-sm-8">
                                            <select class="text-box" id="units" name="units">
                                                <?php  
                                                    for ($x = 1; $x <= $row['available']; $x++) {
                                                    echo '<option value="'. $x .'">'. $x .'</option>';
                                                    }
                                              ?>  
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-bottom: 7px;">
                                        <div class="col-sm-4">Persons</div>
                                        <div class="col-sm-8">
                                            <input type="number" class="text-box" min="1" max="100" value="0" required="" />
                                        </div>
                                    </div>
                                    <div class="row" style="padding-bottom: 7px;">
                                        <div class="col-sm-4">Total</div>
                                        <div class="col-sm-8" data-total="0">0.00</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-primary" name="btn-add">
                                                    Reserved
                                                    <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
                                                </button>
                                        </div>
                                    </div>
                                </form>
                                <?php
                } else {
                    echo "No record was found!";
                }
                
                ?>
                            </div>
        </section>
        <?php 
            include('./layouts/web/footer.php');
            include('./layouts/scripts.php');
            ?>
        <script>
            $('#units').bind('change', function() {
                let rate =  $('div[data-rate]').data('rate');
                let total = rate * $(this).val();
                $('div[data-total]').html(total);
            });
        </script>

</body>

</html>