<?php

session_start();

include('../includes/conn.php');

$name = $_POST["Name"];
$photo = $_POST["photo"];
$rates =  $_POST["rates"];
$status = $_POST["status"];
$person = $_POST["person_liumit"];
$id =  $_POST["id"];

$data = '{
    "success": false,
    "message": "' . $name . '  == ' . $percent . '"
}';


$res = Execute("UPDATE lst_aminities  SET name='$name',photo = '$photo',rates = $rates ,status = '$status',
Person = '$person_limit'  WHERE id = $id");

if ($res){
    $data = '{
        "success": true,
        "message": "success"
    }';
}

header('Content-Type: application/json;');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT) ;