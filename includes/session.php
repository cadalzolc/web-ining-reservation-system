<?php


include('config.php');

session_start();

if (!empty($_SESSION['s-id'])) {
    header('Location:' . BaseURL() . "dashboard.php");
}