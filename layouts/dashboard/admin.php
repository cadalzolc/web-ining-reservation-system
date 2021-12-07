<div class="container-fluid">
    <div class="col-md-1"></div>
    <div class="col-md-10">

    
        <div id="trans-table"></div>
    </div>
    <div class="col-md-1"></div>
</div>

<div id="Olm" class="overlay-modal"></div>

<script type="text/javascript" src="./assets/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="./assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="./assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="./assets/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="./assets/js/toastr.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        GetPendingReservations();
    });

    function GetPendingReservations() {
        $.get("./process/get-list-reservation.php", function (res) {
            $('#trans-table').html(res);
        });
    }

	$(document).on('click', 'button[data-review]', function() {
		var id = $(this).data('review');
		$.get('./layouts/forms/dialog-transaction.php', { uid: id }, function(data) {
			$('#Olm').empty();
			$('#Olm').append(data);
			$('#Olm').show();
		});
	});

    $(document).on('click', 'button[data-pay]', function() {
		var id = $(this).data('pay');
		$.get('./layouts/forms/dialog-pay.php', { uid: id }, function(data) {
			$('#Olm').empty();
			$('#Olm').append(data);
			$('#Olm').show();
		});
	});


    $(document).on('change', "select[data-total]", function () {
        let amt = $('#Amount').val();
        let ds = $('#Discount option:selected').data('percent');
        let tl = parseFloat(amt) - (parseFloat(amt) * parseFloat(ds))
    
        $('#Total').val(numberWithCommas(tl.toFixed(2)));
    });

    $(document).on('click', 'button[data-close]', function(){ 
        $('#Olm').hide();
    }); 
    
    function OnFormSubmitNotify(Frm) {
        $.post('./process/reservation-notify.php?', $(Frm).serialize(), function(data) {
            if (data.success) {
                toastr.success(data.message);
                setTimeout(function(){ 
                    window.location.reload(true);
                }, 2000);
            }else{
                toastr.error(data.message);
            }
        });
        return false;
    }

    function OnFormSubmitPay(Frm) {
        $.post('./process/reservation-pay.php?', $(Frm).serialize(), function(data) {
            if (data.success) {
                toastr.success(data.message);
                setTimeout(function(){ 
                    window.location.reload(true);
                }, 2000);
            }else{
                toastr.error(data.message);
            }
        });
        return false;
    }


    function numberWithCommas(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

</script>