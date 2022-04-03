<?php
ini_set('session.save_path', '../temp');
session_start();

include('../includes/config.php');
include('../includes/conn.php');

$data = '{
    "success": false,
    "message": "Something went wrong in your registration",
    "results": "Error",
	"returl": ""
}';

$User = $_POST["Username"];
$Pass = md5($_POST["Password"]);
$NameF = $_POST["NameF"];
$NameM = $_POST["NameM"];
$NameL = $_POST["NameL"];
$Age = $_POST["Age"];
$Gender = $_POST["Gender"];
$Address = $_POST["Address"];
$Contact = $_POST["Contact"];

$res = Execute("CALL sp_register_customer('$User', '$Pass', '$NameF', '$NameM', '$NameL', '$Gender', '$Address', '$Contact', $Age)");
$count = mysqli_num_rows($res);

if ($count == 1) {
	$row = mysqli_fetch_array($res);
	$data = '{
        "success": true,
        "message": "Successful Registration '. $row["user_id"] . '",
		"results": "",
        "returl": "' . BaseURL() . 'login.php"
    }';
}


header('Content-Type: application/json;');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);