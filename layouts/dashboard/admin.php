<div class="container-fluid">
    <div class="col-md-1"></div>
    <div class="col-md-10">

    
        <div id="trans-table"></div>
    </div>
    <div class="col-md-1"></div>
</div>

<script type="text/javascript" src="./assets/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="./assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="./assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="./assets/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        GetPendingReservations();
    });

    function GetPendingReservations() {
        $.get("./process/get-list-reservation.php", function (res) {
            $('#trans-table').html(res);
        });
    }
</script>