<?php

    function Execute($sql) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "db_reserve";
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }else {
            return $conn->query($sql);
        }
    }

?>