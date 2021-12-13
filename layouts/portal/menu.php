<nav class="navbar navbar-inverse" style="border-radius: 0; padding: 0;">
<div class="container-fluid">
	<a class="navbar-brand" href="#">B'ning Reservation List</a>
	<ul class="nav navbar-nav">
	<?php 
		if ($_SESSION["s-role-id"] == 2){
			
	?>
		<li class="<?php if ($GLOBALS["active-page"] == "history") { echo "active"; } ?>">
			<a href="./history.php">History
				<span class="glyphicon glyphicon-usd" aria-hidden="true"></span>
			</a>
		</li>
	<?php
	}
	elseif ($_SESSION["s-role-id"] == 4) {
	?>
		<li class="<?php if ($GLOBALS["active-page"] == "dashboard") { echo "active"; } ?>">
			<a href="./dashboard.php">Reserved
				<span class="glyphicon glyphicon-list" aria-hidden="true"></span>
			</a>
		</li>
		<li class="<?php if ($GLOBALS["active-page"] == "transaction") { echo "active"; } ?>">
			<a href="./transactions.php">Transaction
				<span class="glyphicon glyphicon-usd" aria-hidden="true"></span>
			</a>
		</li>
		<li class="nav-item dropdown <?php if ($GLOBALS["active-page"] == "maintenance") { echo "active"; } ?>">
			<a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-expanded="false">Maintenance</a>
			<div class="dropdown-menu" aria-labelledby="dropdown01">
				<a class="dropdown-item" href="./customers.php">Customers</a>
				<a class="dropdown-item" href="./aminities-list.php">Aminities</a>
				<a class="dropdown-item" href="./discounts.php">Discounts</a>
				<a class="dropdown-item" href="./aminities-type.php">Aminities Type</a>
			</div>
		</li>
		<li class="<?php if ($GLOBALS["active-page"] == "reports") { echo "active"; } ?>">
			<a href="./reports.php">Reports
				<span class="glyphicon glyphicon-usd" aria-hidden="true"></span>
			</a>
		</li>
	<?php

		}
	
	?>
		
	</ul>
	<ul class="nav navbar-nav navbar-right">
		<?php
			if ($_SESSION["s-role-id"] == 2){
				echo '<li><a href="./" style="color: #fff; background: #009688; font-weight: 700;">Book a Reservation</a></li>';
			}			
		?>	
		<li>
			<a href="./process/auth-logout.php">
				<strong style="margin-right: 10px;">Hi, <?php echo $_SESSION['s-name']; ?></strong>
				<span class="glyphicon glyphicon-log-out"></span> Logout?
			</a>
		</li>
		
	</ul>
</div>
</nav>