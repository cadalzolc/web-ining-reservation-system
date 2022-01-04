<?php

session_start();

include('../includes/conn.php');

$data = '{
    "success": false,
    "message": "Something went wrong "
}';

$idx = $_POST['RevID'];

$sql = "CALL sp_update_reservation_status($idx, 'X')";

$res = Execute($sql);

if ($res) {
    $data = '{
        "success": true,
        "message": "Reservation was successfully cancelled!"
    }';
}

header('Content-Type: application/json;');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);