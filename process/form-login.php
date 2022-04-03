<?php
ini_set('session.save_path', '../temp');
session_start();

include('../includes/conn.php');

$data = '{
    "success": false,
    "message": "Invalid username/password",
    "results": ""
}';

$User = $_POST["Username"];
$Pass = md5($_POST["Password"]);

$res = Execute("CALL sp_login_customer('$User', '$Pass')");
$count = mysqli_num_rows($res);

if ($count == 1) {
   
    $row = mysqli_fetch_array($res);

    $customer_id = $row["user_id"];
    $amenity_id = $_POST["T1"];
    $check_in = $_POST["T2"];
    $no_units = $_POST["T3"];
    $no_persons = 0;

    $rev = Execute("CALL sp_add_reservation($amenity_id, $customer_id,  $no_units, '$check_in', $no_persons);");
    $inf = mysqli_fetch_array($rev);

    $_SESSION["s-id"] = $row["user_id"];
    $_SESSION["s-role-id"] = $row["role_id"];
    $_SESSION["s-role"] = $row["role"];
    $_SESSION["s-name"] = $row["fullname"];
    $_SESSION["s-age"] = $row["age"];
    $_SESSION["s-gender"] = $row["gender"]; 
    $_SESSION["s-contact"] = $row["contact"];
    $_SESSION["s-address"] = $row["address"];

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