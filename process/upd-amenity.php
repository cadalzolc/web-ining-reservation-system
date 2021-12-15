<?php

session_start();

include('../includes/conn.php');
    $id = $_GET['id'];
    $qry = mysqli_query($db,"SELECT * FROM typ_aminities where id ='$id'");
    $info = mysqli_fetch_assoc($res_info);
  
    if(isset($_POST['update']))

        {
            $name = $_POST["Name"];
            $rates = $_POST["rates"];
            $unit = $_POST["available"];
            $person_limit = $_POST["capacity"];
            $type_id =  $_POST["type"];

        $data = '{
            "success": false,
            "message": "UNSUCCESSFUL UPDATE"
        }';

            $res = Execute ("call sp_update_amenity SET name='$name',rates = $rates,available = $unit,
            capacity = $person_limit,type = $typeid WHERE id = $id");

        if ($res)
        {
            $data = '{
                "success": true,
                "message": "success"
            }';
        }
        {
        header('Content-Type: application/json;');

        echo json_encode(json_decode($data), JSON_PRETTY_PRINT) ;

        }}