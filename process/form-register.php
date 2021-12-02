<?php

session_start();

include('../includes/conn.php');

$data = '{
    "success": false,
    "message": "Something went wrong in your registration",
    "results": ""
}';


header('Content-Type: application/json;');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);