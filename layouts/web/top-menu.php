<nav class=" nim-menu navbar navbar-default navbar-fixed-top">

    <div class="container">
        <div class="navbar-header">

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                data-target="#bs-example-navbar-collapse-1">

                <span class="sr-only">Toggle navigation</span>

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>

            </button>

            <a class="navbar-brand" href="./">B<span class="themecolor">'</span>ning</a>

        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav navbar-right">

                <li><a href="./" class="page-scroll">
                        <h3>Home</h3>
                    </a></li>
                <ul class="nav navbar-nav navbar-right">

                    <li><a href="./" class="page-scroll">
                            <h3>Gallery</h3>
                        </a></li>
                    <li><a href="./about.php" class="page-scroll">
                            <h3>About</h3>
                        </a></li>
                        <li><a href="./about.php" class="page-scroll">
                            <h3>Contact</h3>
                        </a></li>


                    <?php 
                    
                    if (!empty($_SESSION["s-id"])) {

                    ?>
                    <li style="margin-left: 15px;">Welcome 
                        <h3><?php echo $_SESSION["s-name"]; ?></h3>
                    </li>            
                    <li>
                        <a href="./dashboard.php" class="page-scroll">
                            <h3>Go To Dashbaord</h3>
                        </a>

                    <?php
                    } 
                    else 
                    {  
                    ?>

                    <li>
                        <a href="./signup.php" class="page-scroll">
                            <h3>Register</h3>
                        </a>
                    </li>

                    <li><a href="./login.php/" class="page-scroll">
                            <h3>Login</h3>
                        </a></li>

                    <?php
                    }

                    ?>


                </ul>
        </div>
    </div>
</nav>