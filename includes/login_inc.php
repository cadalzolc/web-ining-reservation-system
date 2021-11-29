<?php
  if (isset($_POST["submit"])) 
  {
    $un = $_POST["uid"];
    $pwd = $_POST["pwd"];

    include '../database/connection2.php';
    include 'functions_inc.php';

    if (emptyInputLogin($un, $pwd) !== false)
    {
      header("location: ../admin/indexClient.php?error=emptyinput");
      exit();
    }

    loginUser($conn, $un, $pwd);
  }
  else
  {
    header("location: ../admin/indexClient.php");
    exit();
  }
