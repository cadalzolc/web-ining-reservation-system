<?php

  require_once 'functions_inc.php';

  if (isset($_POST['add'])) 
  {
    if (emptyInputReserved($bookdep) !== false)
    {
      header("location: ../reserved.php?error=emptyinput");
      exit();
    }
    else 
    {
      header("location: ../accomodation.php");
    } 
  }
?>