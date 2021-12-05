<?php

session_start();

include('../includes/conn.php');

$name = $_POST["Name"];
$percent = $_POST["Percent"];


$data = '{
    "success": false,
    "message": "' . $name . '  == ' . $percent . '"
}';



//code

header('Content-Type: application/json;');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);