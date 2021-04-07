<?php
    require '../../includes/connection.php';

    $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);

    $sql = "DELETE FROM roles WHERE id = ".$id;
    $op = mysqli_query($con,$sql);
    $message = '';

    if($op){
        $message = 'Record Delete';
    }else{
        $message = 'Erorr In Delete';
    }

    $_SESSION['message'] = $message;
    header('location: displayRoles.php');

?>