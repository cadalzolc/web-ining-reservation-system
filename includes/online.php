<?php
ini_set('session.save_path', '../temp');
session_start();

$online = 0;

if (!empty($_SESSION['s-id'])) {
    $online = 1;
}

echo $online;
