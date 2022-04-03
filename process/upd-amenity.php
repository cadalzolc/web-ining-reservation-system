<?php
ini_set('session.save_path', '../temp');
session_start();

include('../includes/conn.php');

$name = $_POST["Name"];
$rates = $_POST["Rates"];
$unit = $_POST["Available"];
$person_limit = $_POST["Capacity"];
$type_id =  $_POST["Type"];
$id =  $_POST["Id"];

$data = '{
"success": false,
"message": "Please Try Again"
}';

$res = Execute("CALL sp_update_amenity($id, '$name', $rates, $unit, $person_limit, $type_id)");

if ($res){
    $data = '{
        "success": true,
        "message": "Successfully Updated"
    }';

}

header('Content-Type: application/json;');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT) ;
        