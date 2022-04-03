<?php
ini_set('session.save_path', '../temp');
session_start();

include('../includes/conn.php');

$name = $_POST["Name"];
$rates = $_POST["Rate"];
$id =  $_POST["id"];

$data = '{
    "success": false,
    "message": "Please Try Again!!!
}';


$res = Execute("CALL sp_update_amenity_type($id, '$name', $rates)");

if ($res){
    $data = '{
        "success": true,
        "message": "Successfully Updated"
    }';
}
    
header('Content-Type: application/json;');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);