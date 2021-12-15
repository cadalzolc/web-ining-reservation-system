<?php 

session_start();

if (empty($_SESSION['s-id'])) {
	require_once("./includes/config.php");
    header('Location:' . BaseURL() . "login.php");
	exit;
}

include('./includes/conn.php');

$GLOBALS["active-page"] = "Amenity Type";

$res =  Execute("SELECT * FROM typ_aminities;")

?>

<!DOCTYPE html>
<html lang="">
<?php include("./layouts/portal/head.php") ?>

<body>

    <?php include("./layouts/portal/menu.php") ?>
    <br />
    <div class="container-fluid">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div>
                <button class="btn btn-primary" onclick="AddAmenity()">Add Amenity</button>
            </div>
            <div id="trans-table">
                <table id="myTable-trans" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Rate</th>
                            <th style="width: 35px !important;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $cnt =  1;
                            foreach($res as $t): 
                        ?>
                        <tr>
                            <td><?= $cnt; ?></td>
                            <td><?= $t['name']; ?></td>
                            <td>
                            <?= $t['rates']; ?>
                            </td>
                            <td style="padding: 3px;">
                                <button type="button" class="btn btn-success btn-xs"
                                    style="height: 100% !important; width: 100%; line-height: 2;"
                                    onclick="UpdateAmenityType(<?= $t['id'] ?>)">Update</button>
                            </td>
                        </tr>
                        <?php 
                            $cnt++;
                            endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
    <div id="Olm" class="overlay-modal"></div>
   <?php include('./layouts/portal/scripts.php'); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#myTable-trans').DataTable();
        });

        function AddAmenity() {
            $.get('./layouts/forms/dialog-aminity-type.php', function (data) {
                $('#Olm').empty();
                $('#Olm').append(data);
                $('#Olm').show();
            })
        }

        function SaveAminityType(Frm) {
            $.post('./process/add-aminity-type.php', $(Frm).serialize(), function (res) {
                if (res.success) {
                    toastr.success(res.message);
                    setTimeout(function () {
                        window.location.reload(true);
                    }, 2000);
                } else {
                    toastr.error(res.message);
                }
            })
            return false;

        }

        function UpdateAmenityType(n) {
            $.get('./layouts/forms/dialog-upd-am-typ.php', {
                id: n
            }, function (data) {
                $('#Olm').empty();
                $('#Olm').append(data);
                $('#Olm').show();
            })
        }

        function SaveAmenityTypeUpdate(Frm) {
            $.post('./process/upd-amenity-type.php', $(Frm).serialize(), function (res) {
                if (res.success) {
                    toastr.success(res.message);
                    setTimeout(function () {
                        window.location.reload(true);
                    }, 2000);
                } else {
                    toastr.error(res.message);
                }
            });
            return false;
        }

        $(document).on('click', 'button[data-close]', function () {
            $('#Olm').hide();
        });
    </script>
</body>

</html>