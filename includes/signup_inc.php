<?php
  if (isset($_POST['btn-add'])) 
  {
    $fn = $_POST['fn'];
    $add = $_POST['add'];
    $con = $_POST['con'];
    $age = $_POST['age'];
    $gen = $_POST['gen'];
    $un = $_POST['un'];
    $pwd = $_POST['pwd'];


    require_once '../database/connection2.php';
    require_once 'functions_inc.php';

    if (emptyInputSignup($fn, $add, $con, $age, $gen, $un, $pwd) !== false)
    {
      header("location: ../signup.php?error=emptyinput");
      exit();
    }

    if (invalidUid($un) !== false)
    {
      header("location: ../signup.php?error=invalidUid");
      exit();
    }
    
    if (uidExists($conn, $un) !== false)
    {
      header("location: ../signup.php?error=usernametaken");
      exit();
    }

    createUser($conn, $fn, $add, $con, $age, $gen, $un, $pwd);


  }

  else
  {
    header("location: signup.php");
    exit();
  }
  ?>