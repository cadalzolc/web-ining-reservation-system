<?php
ini_set('session.save_path', '../temp');
session_start();

include('../includes/config.php');
include('../includes/conn.php');

$data = '{
    "success": false,
    "message": "Invalid username/password",
    "returl": ""
}';

$User = $_POST["Username"];
$Pass = md5($_POST["Password"]);

$res = Execute("CALL sp_login('$User', '$Pass')");
$count = mysqli_num_rows($res);

if ($count == 1) {
   
    $row = mysqli_fetch_array($res);

    $_SESSION["s-id"] = $row["user_id"];
    $_SESSION["s-role-id"] = $row["role_id"];
    $_SESSION["s-role"] = $row["role"];
    $_SESSION["s-name"] = $row["fullname"];
    $_SESSION["s-age"] = $row["age"];
    $_SESSION["s-gender"] = $row["gender"]; 
    $_SESSION["s-contact"] = $row["contact"];
    $_SESSION["s-address"] = $row["address"];

    $data = '{
        "success": true,
        "message": "Successful login",
        "returl": "' . BaseURL() . 'dashboard.php"
    }';
}

header('Content-Type: application/json;');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);