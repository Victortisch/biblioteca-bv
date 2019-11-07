<?php
session_start();

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
    {

    }
    else
    {
      header("Location:funciones/perm_denied.html"); 

    exit;
    }

    $now = time(); // checking the time now when home page starts

      if($now > $_SESSION['expire'])
      {
      
      session_destroy();

      header("Location:funciones/time_expired.html");
      }
 ?>