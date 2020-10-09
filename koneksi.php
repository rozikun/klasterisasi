<?php

    $host = "localhost";
    $user = "root";
    $pass = "";
    $database = "dbta";

    $conn = mysqli_connect($host,$user,$pass,$database) or die (mysqli_error($conn));
    
?>