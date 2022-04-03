<?php


include('config.php');
ini_set('session.save_path', '../temp');
session_start();

if (!empty($_SESSION['s-id'])) {
    header('Location:' . BaseURL() . "dashboard.php");
}