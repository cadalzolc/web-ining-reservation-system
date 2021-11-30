<?php
include('./includes/conn.php');

$id = $_GET['id'];
$msg = "";
$results = Execute("SELECT * FROM vw_lst_amenities WHERE id = $id");

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
                            style="background: url('./uploads/img/default.jpg') no-repeat center center; background-size: cover;">
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <form class="form-horizontal" role="form" id="form-login"
                                        action="/medallion/admin/indexClient.php" method="POST">

                                        <div class="form-group">
                                            <label class="control-label col-sm-2">Description:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="username"
                                                    placeholder="Enter Username" autofocus="" required="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-2">Password:</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" name="pwd"
                                                    placeholder="Enter password" required="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <div class="checkbox">
                                                    <label><input type="checkbox"><?php echo $row['name']; ?></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" name="submit" class="btn btn-default">Login
                                                    <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
                                                </button>
                                            </div>
                                        </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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
    </body>

    </html>