<?php
ini_set('session.save_path', '../temp');
session_start();

include('../includes/conn.php');

$idx = $_POST['RevID'];
$csx = $_POST['RevCS'];
$amx = $_POST['RevAM'];
$datex = $_POST['RevDate'];
$sql = "CALL sp_update_reservetion_pay($idx, $csx, $amx, '$datex')";
$data = '{
    "success": false,
    "message": "Something went wrong "
}';
$res = Execute($sql);

if ($res) {
    $data = '{
        "success": true,
        "message": "Reservation was successfully paid!"
    }';
}

header('Content-Type: application/json;');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);