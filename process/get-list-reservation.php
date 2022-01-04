<?php 
require_once('../includes/conn.php');
$res =  Execute("CALL sp_get_reservation_for_review;")
?>

<table id="myTable-trans" class="table table-bordered table-hover" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>No</th>
			<th style="width: 60px;">Booked Id</th>
			<th>Date</th>
			<th>Customer</th>
			<th>Aminity</th>
			<th>Amount</th>
			<th>Units</th>
			<th>Check-In</th>
			<th>Status</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$cnt =  1;
		foreach($res as $t): 

			?>
		<tr>
		
			<td><?= $cnt; ?></td>
			<td>RS<?php echo 1000 +  $t['id'];?></td>
			<td><?= $t['date']; ?></td>
			<td><?= $t['customer']; ?></td>		
			<td><?= $t['aminity']; ?></td>
			<td><?= $t['amount']; ?></td>
			<td><?= $t['no_units']; ?></td>
			<td><?= $t['check_in']; ?></td>
			<td>
				<?php 
				switch($t['status']){
					case "P": echo "Review"; break;
					case "S": echo "Send"; break;
					case "C": echo "Confirmed"; break;
				}
				?>
			</td>
			<td style="padding: 3px; display: flex;">
				<?php 
				switch($t['status']){
					case "P": 
				?>
				<button type="button" 
					data-review="<?php echo $t['id']; ?>"
					class="btn btn-success btn-xs" 
					style="height: 100% !important; width: 100%; line-height: 2;">
					View
				</button>
				<?php
						break;
					case "C":
				?>
				<button type="button" 
					data-pay="<?php echo $t['id']; ?>"
					class="btn btn-success btn-xs" 
					style="height: 100% !important; width: 100%; line-height: 2; margin-right: 3px;">
					Pay
				</button>
				<button type="button" 
					data-cancel="<?php echo $t['id']; ?>"
					class="btn btn-danger btn-xs" 
					style="height: 100% !important; width: 100%; line-height: 2;">
					Cancel
				</button>
				<?php
						break;
					case "S":
				?>
					<input type="hidden" data-mobile="<?= $t['contact']; ?>"  data-id="<?= $t['id']; ?>" data-trans="RS<?= ($t['id'] + 1000); ?>"/>
					<button type="button" 
						data-cancel="<?php echo $t['id']; ?>"
						class="btn btn-danger btn-xs" 
						style="height: 100% !important; width: 100%; line-height: 2;">
						Cancel
					</button>
				<?php
						break;
				}
				?>
				
			</td>
		</tr>
		<?php 
		$cnt++;
		endforeach; ?>
	</tbody>
</table>

<script type="text/javascript">
	const params = {
		method: 'GET',
		headers: {
			'accept': 'application/json'
		}
	};
	$(document).ready(function () {
		$('#myTable-trans').DataTable();		
		setInterval(function () {
			$.each($("input[data-mobile]"), function( index, value ) {
				GetReply($(this).data("mobile"), $(this).data("trans"), $(this).data("id"));
			});
		}, 
		5000);
	});
	async function GetReply(mobile, trans, id){
		var payload = { "mobile": mobile, "trans" : trans, "id": id };
		$.get("./process/get-logs.php", payload, function(res){
			var postData = { "mobile": mobile, "trans" : trans, "id": id, "body": res.data.body };
			$.post('./process/push-logs.php', postData);
		});	
	}
</script>