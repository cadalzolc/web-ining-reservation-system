<?php

session_start();

include('../includes/conn.php');

$data = '{
    "success": false,
    "message": "Something went wrong in your registration",
    "results": ""
}';

$User = $_POST["Username"];
$Pass = md5($_POST["Password"]);
$NameF = $_POST["NameF"];
$NameM = $_POST["NameM"];
$NameL = $_POST["NameL"];
$Age = $_POST["Age"];
$Gender = $_POST["Gender"];
$Address = $_POST["Address"];
$Contact = $_POST["Contact"];

$res = Execute("CALL sp_register_customer('$User', '$Pass', '$NameF', '$NameM', '$NameL', '$Gender', '$Address', '$Contact', $Age)");
$count = mysqli_num_rows($res);

if ($count == 1) {

    $row = mysqli_fetch_array($res);

    $customer_id = $row["user_id"];
    $amenity_id = $_POST["T1"];
    $check_in = $_POST["T2"];
    $no_units = $_POST["T3"];
    $no_persons = $_POST["T4"];

    $rev = Execute("CALL sp_add_reservation($amenity_id, $customer_id,  $no_units, '$check_in', $no_persons);");
    $inf = mysqli_fetch_array($rev);

    $data = '{
        "success": true,
        "message": "Successful login",
        "results": {
            "trn" : "' . $inf["trans_no"] .'",
            "date" : "' . $check_in .'",
            "name" : "' . $row["fullname"].'"
        }
    }';

}

header('Content-Type: application/json;');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);