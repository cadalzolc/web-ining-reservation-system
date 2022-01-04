<?php 

header('Content-Type: application/json;');

$mobile = $_GET['mobile'];

$url = 'https://gsm.niftyappmakers.com/globe/logs?mobile=' . $mobile;
$crl = curl_init();

curl_setopt($crl, CURLOPT_URL, $url); 
curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($crl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

$res = curl_exec($crl);

curl_close($crl);

$data = '{
    "success": true,
    "message": "Success",
    "data": ' . $res .'
}';

header('Content-Type: application/json;');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);

?>