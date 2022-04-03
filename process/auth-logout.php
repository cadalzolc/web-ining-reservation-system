<?php

include('../includes/config.php');

ini_set('session.save_path', '../temp');

session_start();
session_destroy();

header('Location:' . BaseURL());