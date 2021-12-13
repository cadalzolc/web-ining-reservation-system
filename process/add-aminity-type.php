<?php

session_start();

include('../includes/conn.php');

$name = $_POST["Name"];
$rate = $_POST["Rate"];


$data = '{
    "success": false,
    "message": "ERROR"
}';


$res = Execute("call sp_add_amenity('$name', '$rate')");

if ($res){
    $data = '{
        "success": true,
        "message": "Successfully Added"
    }';
}

header('Content-Type: application/json;');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT) ;