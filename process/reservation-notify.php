<?php

session_start();

include('../includes/conn.php');

$idx = $_POST["RevNo"];
$amount = $_POST["Amount"];
$name = $_POST["Customer"];
$original = $_POST["original"];
$units = $_POST["RevUnits"];
$submit = $_POST['submit'];

$data = '{
    "success": false,
    "message": "Something went wrong ' . $submit . '"
}';

$sql = "";
$msg = "";

switch ($submit) {
    case "good":
    case "notify":
        $sql = "CALL sp_update_reservation_with_changes('$idx', 'S', $original, $units);";
        $msg = " Successfully process and sent notification to customer";
        break; 
    default:
        $sql = "CALL sp_update_reservation_with_changes('$idx', 'X', $original, $units);";
        $msg = "Successfully cancelled";
        break; 
}


$res = Execute($sql);

if ($res) {

    //Send SMS

    $data = '{
        "success": true,
        "message": "' . $msg  .'"
    }';
}


header('Content-Type: application/json;');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);
