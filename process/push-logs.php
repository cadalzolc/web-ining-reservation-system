<?php

include('../includes/conn.php');

$id = $_POST['id'];
$body = $_POST['body'];
$mobile = $_POST['mobile'];
$trans = $_POST['trans'];

$data = '{
    "success": false,
    "message": "Failed"
}';

if (strpos($body, 'RESERVATION CONFIRMED') !== false) {
    
    $no = trim(str_replace('RESERVATION CONFIRMED', '', $body));
    $is_matched = strcmp($no, $trans);

    if ($is_matched === 0) {
        $ret = Execute("CALL sp_update_reservation_status($id, 'C')");
        $data = '{
            "success": true,
            "message": "Success "
        }';
    } else
    {
    
        $data = '{
            "success": false,
            "message": "Failed ' . $no . ', ' . $trans . ' ' . $is_matched .'"
    }';
    }
}



header('Content-Type: application/json;');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);

?>