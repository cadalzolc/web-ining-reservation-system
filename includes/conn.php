<?php

    function Execute($sql) {
        $servername = "192.168.1.167";
        $username = "root";
        $password = "";
        $database = "medallion";
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }else {
            return $conn->query($sql);
        }
    }

?>