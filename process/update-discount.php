<?php
ini_set('session.save_path', '../temp');
session_start();

include('../includes/conn.php');

$name = $_POST["Name"];
$percent = $_POST["Percent"];
$id =  $_POST["id"];

$data = '{
    "success": false,
    "message": "' . $name . '  == ' . $percent . '"
}';

$disc = ($percent / 100);

$res = Execute("UPDATE typ_discount SET name='$name', percent=$disc WHERE id = $id");

if ($res){
    $data = '{
        "success": true,
        "message": "success"
    }';
}

header('Content-Type: application/json;');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT) ;