<?php

session_start();

include('../includes/conn.php');

$idx = $_POST["RevNo"];
$amount = $_POST["Amount"];
$name = $_POST["Customer"];

$data = '{
    "success": false,
    "message": "Something went wrong "
}';

$res = Execute("CALL sp_update_reservation_status('$idx', 'S');");

if ($res) {

    //Send SMS

    $data = '{
        "success": true,
        "message": "Reservation notification was successfuly sent to customer"
    }';
}

header('Content-Type: application/json;');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);
