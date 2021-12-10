<?php

session_start();

include('../includes/conn.php');

$name = $_POST["name"];
$rates = $_POST["rate"];
$unit = $_POST["available"];
$person_limit = $_POST["capacity"];
$typeid = $_POST["type"];

$data = '{
    "success": false,
    "message": "Error"
}';

$res = Execute("call sp_add_amenity('$name', $rates, $unit, $person_limit, $typeid)");

if ($res) {
    $data = '{
        "success": true,
        "message": "Successfully Added"
    }';
}

header('Content-Type: application/json;');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT) ;