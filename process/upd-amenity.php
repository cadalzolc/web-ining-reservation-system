<?php

session_start();

include('../includes/conn.php');

$name = $_POST["Name"];
$person_limit = $_POST["capacity"];
$unit = $_POST["available"];
$rates = $_POST["rate"];
$id =  $_POST["id"];

$data = '{
    "success": false,
    "message": "UNSUCCESSFUL"
}';


$res = Execute("UPDATE sp_update_amenity SET name='$name',capacity = $person_limit, available = $unit,rate = $rates
 WHERE id = $id");

if ($res){
    $data = '{
        "success": true,
        "message": "success"
    }';
}

header('Content-Type: application/json;');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT) ;