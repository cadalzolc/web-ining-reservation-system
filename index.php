<?php 
include('./includes/conn.php');
include('./includes/config.php');
session_start();

?>

<!DOCTYPE html>
<htm>

    <head>
        <?php include('./layouts/web/meta.php');?>
    </head>

    <body>

        <?php include('./layouts/page-loader.php');?>


        <div class="wrapper">

            <?php include('./layouts/web/top-menu.php');?>
            <section class="main-heading" id="home">

                <div class="overlay">

                    <div class="container">

                        <div class="row">

                            <div class="main-heading-content col-md-12 col-sm-12 text-center">

                                <div class="color">
                                    <h1 class="main-heading-title"><span class="main-element themecolor"
                                            data-elements=" B'NING, B'NING, B'NING"></span></h1>

                                    <h1 class="main-heading-title"><span class="main-element themecolor"
                                            data-elements="Reservation,Reservation,Reservation"></span></h1>
                                </div>

                                <div class="btn-bar">


                                </div>

                            </div>

                        </div>

                    </div>

                </div>


            </section>

            <div class="section custom-bg mt-3 mb-0" style="--custom-bg: #F3F3ED; padding: 100px 0;">
                <div class="container">

                    <!-- Shop
						============================================= -->
                    <div id="shop" class="shop row gutter-30 col-mb-30 mt-3">

                        <!-- Title -->
                        <div class="col-lg-12" style="padding-bottom: 15px;">
                            <h3 class="mb-4 fw-normal h1">Resorts Gallery<span data-animate="svg-underline-animated"
                                    class="svg-underline nocolor svg-underline-animated animated"><span></span></span>
                            </h3>
                            <p class="op-07 mb-4">Leave the chaos of busy cities and crowded streets behind and welcome to jungle.
                                Explore BNing Hidden Farm Resorts <br>
                                
                                Reserve Now!.</p>
                           
                        </div>

                        <?php 
                            
                                $results = Execute("SELECT * FROM vw_lst_amenities");

                                if ($results) {
                                    while($row = mysqli_fetch_assoc($results)) {
                            ?>
                        <!-- Product 1 -->
                        <div class="product col-sm-6 col-md-4 col-lg-3">
                            <div class="grid-inner">
                                <div class="product-image">
                                    <a href=""><img src="./uploads/img/<?php echo $row['photo']; ?>"
                                            alt="Light Grey Sofa"></a>
                                    <a href="#"><img src="./uploads/img/<?php echo $row['photo']; ?>"
                                            alt="Light Grey Sofa"></a>
                                    <div class="bg-overlay">
                                        <div class="bg-overlay-content align-items-end justify-content-between not-animated"
                                            data-hover-animate="fadeIn" data-hover-speed="400"
                                            style="animation-duration: 400ms;">
                                        </div>
                                    </div>
                                </div>
                                <div class="product-desc">
                                    <div class="product-title mb-0">
                                        <h4 class="mb-0">
                                            <a class="fw-medium" href="#">
                                                <?php echo $row['name']; ?>
                                            </a>
                                        </h4>
                                    </div>
                                    <h5 class="product-price fw-normal"> ₱ <?php echo $row['rates']; ?></h5>
                                    <a class="btn btn-danger" href="./amenities.php?id=<?php echo $row["id"]; ?>&date=<?php echo date('Y-m-d'); ?>">View
                                        Info</a>
                                </div>
                            </div>
                        </div>
                        <?php
                                    }
                                }
                            
                            ?>




                    </div><!-- #shop end -->

                </div>
    
            </div>


            <?php 
            include('./layouts/web/footer.php');
            include('./layouts/scripts.php');
            ?>

    </body>

</html>