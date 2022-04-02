<?php

include('../includes/func.php');
include('../includes/conn.php');

$success = false;
$msg = "Something went wrong in your request.";

$id = $_POST['Id'];

$qry = Execute("CALL sp_check_in($id);");

if ($qry) {
    $success = true;  
    $msg = "Checked in successful";
}

$data = '{
    "success": '. ToBoolean($success) .',
    "message": "'. $msg .'"
}';

header('Content-Type: application/json');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);

?>