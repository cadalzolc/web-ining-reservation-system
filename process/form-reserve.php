<?php

session_start();

include('../includes/conn.php');

$data = '{
    "success": false,
    "message": "Something went wrong in your reservation",
    "results": ""
}';

$customer_name = $_SESSION["s-name"];
$customer_id = $_SESSION["s-id"];
$amenity_id = $_POST["AID"];
$check_in = $_POST["Check-in"];
$no_units = $_POST["Units"];
$no_persons = $_POST["Person"];

$rev = Execute("CALL sp_add_reservation($amenity_id, $customer_id,  $no_units, '$check_in', $no_persons);");
$inf = mysqli_fetch_array($rev);

if ($inf) {
    $data = '{
        "success": true,
        "message": "Your reservation was successful",
        "results": {
            "trn" : "' . $inf["trans_no"] .'",
            "date" : "' . $check_in .'",
            "name" : "' . $customer_name .'"
        }
    }';

}

header('Content-Type: application/json;');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);