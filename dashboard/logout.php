<?php    
   require 'includes/connection.php';
   include 'includes/helperFunction.php';

   session_destroy();
    header("Location: login.php");
   

?>