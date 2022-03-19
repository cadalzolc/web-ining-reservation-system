<?php

session_start();

include('../includes/conn.php');
include('../includes/sms.php');

$idx = $_POST["RevNo"];
$amount = $_POST["Amount"];
$name = $_POST["Customer"];
$original = $_POST["original"];
$units = $_POST["RevUnits"];
$submit = $_POST['submit'];
$cid = $_POST['customerid'];
$arrival = $_POST['CheckIn'];
$aminity = $_POST['Aminity'];

$sql = "";
$msg = "";

switch ($submit) {
    case "good":
    case "notify":
        $sql = "CALL sp_update_reservation_with_changes('$idx', 'S', $original, $units);";
        $msg = "Successfully process and sent notification to customer";
        break; 
    default:
        $sql = "CALL sp_update_reservation_with_changes('$idx', 'X', $original, $units);";
        $msg = "Successfully cancelled";
        break; 
}

$data = '{
    "success": false,
    "message": "' . $sql .'"
}';

$res = Execute($sql);

if ($res) {

    $sms_response = "";
    $res_cr = Execute("SELECT * FROM user_profile WHERE id = $cid;");
    $cs = mysqli_fetch_array($res_cr);

    $sms = new SmsRenato();
    $sms->to = $cs['contact'];

    //Send SMS
    switch ($submit) {
        case "good": 
            
            $body = "Hi " . $name .  ", we would like to have your confirmation with the reservation details. \n\nReservation No: RS" . ($idx + 1000) . "\nDate Arrival: " . $arrival . "\nName of Aminity:" . $aminity . "\nNo. of Units:" . $units . "\nAmount:" . number_format($amount, 2, '.',  ',') . "\n\nIf your are still interested with your reservation please reply 'RESERVATION CONFIRMED RS" . ($idx + 1000) ."'. And if there is a problem just call '09778299069' to reach out with our staff. \nThank you";

            $sms->message = $body;
            $sms_response = $sms->Send();

            break;
        case "notify":

            $body = nl2br('Hi ' . $name .  ' your reservation is not available.');

            $sms->message = $body;
            $sms_response = $sms->Send();

            break;   
    }

    $data = '{
        "success": true,
        "message": "' . $msg .'"
    }';

}

header('Content-Type: application/json;');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);