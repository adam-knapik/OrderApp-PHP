<?php
    session_start();

    include 'config.php';

    if(isset($_GET['order_id'])) {
        $order_id = $_GET['order_id'];
        $deleteOrder = "DELETE FROM orders WHERE order_id = $order_id;";
        $deleteOrderItems = "DELETE FROM order_items WHERE item_order_id = $order_id;";

        if($conn->query($deleteOrderItems) === FALSE) {
            echo "ERROR: #1";
        } 
        else {
            if($conn->query($deleteOrder) === FALSE) {
                echo "ERROR: #2";
            }
            else {
                echo "<script>window.location = 'orders.php';</script>";
            }
        }

        header('orders.php');
    }
    else {
        echo "Error: #3";
    }
?>