<?php

session_start();

include('../includes/conn.php');

$name = $_POST["Name"];
$Rate = $_POST["Rate"];
$PersonLimit = $_POST["Person Limit"];
$Units = $_POST["Unit"];

$data = '{
    "success": false,
    "message": "' . $name . '==' . $rate. '==' . $person_limit . '==' . $unit. '"
}';

$res = Execute("call sp_add_amenity('$name', $rate, $person_limit,$unit)");

if ($res){
    $data = '{
        "success": true,
        "message": "success"
    }';
}

header('Content-Type: application/json;');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT) ;