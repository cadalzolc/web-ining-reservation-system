<?php

session_start();

include('../includes/conn.php');

$name = $_POST["Name"];
$percent = $_POST["Percent"];


$data = '{
    "success": false,
    "message": "' . $name . '  == ' . $percent . '"
}';

if (isset($_POST['SAVE'])){
    $ame = $_POST ['Name'];
    $Percent = $post['percent'];
    
    $mysqli->query("INSERT INTO data (Name,Percent) VALUES ('$Name','$Percent'")or 
    die ($mysqli->error);
}
header('Content-Type: application/json;');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT) ;