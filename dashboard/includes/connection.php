<?php
session_start();

    $server = 'localhost';
    $user = 'root';
    $password = '';
    $dbname = 'portfolio';
    
    $con = mysqli_connect($server, $user, $password, $dbname);

    if(!$con){
        die('Error In Connection'.mysqli_connect_error());
    }
?>