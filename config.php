<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $database = "order_db";

    $conn = mysqli_connect($host, $user, $pass, $database);

    if(mysqli_connect_errno()) {
        echo "Failed connect mysql: ".mysqli_connect_errno();
    }
?>