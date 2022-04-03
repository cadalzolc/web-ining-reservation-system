<?php
ini_set('session.save_path', '../temp');
session_start();

include('../includes/conn.php');

$name = $_POST["Name"];
$percent = $_POST["Percent"];


$data = '{
    "success": false,
    "message": "' . $name . '  == ' . $percent . '"
}';

$disc = ($percent / 100);

$res = Execute("call sp_add_discount('$name', $disc)");

if ($res){
    $data = '{
        "success": true,
        "message": "Successfully Added"
    }';
}

header('Content-Type: application/json;');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT) ;