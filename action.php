<?php
    session_start();
    require('config.php');

    $error = false;
    $error_alert = "";

    $user = $_SESSION['id'];
    $usershort = $_SESSION['shortname'];
    $contractor = $_POST['contractor'];
    $company = $_POST['company'];
    $subTotal = $_POST['sub_total'];
    $destination = $_POST['destination'];
    $payment = $_POST['payment'];
    $orderDate = $_POST['order_date'];
    $deliveryDate = $_POST['delivery_date'];
    $delivery = $_POST['delivery'];
    $note = $_POST['note'];
    $type = $_POST['type'];
    $numerzam = $_POST['nozam'];

    $subTotal = 0;

    foreach($_POST['product_name'] as $key => $value)  {
        $value;
        $price = $_POST['product_price'][$key];
        $qty = $_POST['product_quantity'][$key];
        $total = $_POST['product_total'][$key];

        $subTotal += intval($total);

        if(empty($value) || empty($price) || empty($qty) || empty($total)) {
            $error = true;
            $error_alert = 'Uzupełnij wszystkie pola produktów!';
        }
    }

    if($error == true) {
        echo '<div class="alert alert-danger" role="alert">'.$error_alert.'</div>';
    }

    if($error == false && !empty($user) && !empty($contractor)  && !empty($subTotal) && !empty($destination) && !empty($payment) && !empty($delivery) && !empty($type) && !empty($deliveryDate) && !empty($orderDate)) {
        $orderNumber = generateOrderNumber2($numerzam, date("Y"), $usershort);

        if(empty($note)) { $note = ''; }

        $insert_order = "INSERT INTO orders (order_number, order_contractor, order_user, order_company, order_destination, order_value_net, order_payment_method, order_date,  order_delivery_date, order_delivery, order_note, order_type) 
                                    VALUES ('$orderNumber', $contractor, $user,  '1', '$destination', $subTotal, '$payment', '$orderDate' ,'$deliveryDate', '$delivery', '$note', '$type');";

        if($conn->query($insert_order) === FALSE) {
            $error = true;
            $error_alert = '<div class="alert alert-danger" role="alert">Error: '.$insert_order.' '.$conn->error.'</div>';
        }

        else { 
            foreach($_POST['product_name'] as $key => $value)  {
                $value;
                $order_id = getOrderId();
                $price = $_POST['product_price'][$key];
                $qty = $_POST['product_quantity'][$key];
                $total = $_POST['product_total'][$key];

                $insert_items = "INSERT INTO order_items (item_name, item_order_id, item_price, item_quantity, item_subtotal) VALUES ('$value', $order_id, $price, $qty, $total);";

                if ($conn->query($insert_items) === FALSE) {
                    $error = true; 
                    $error_alert = '<div class="alert alert-danger" role="alert">Error: '.$insert_items.' '.$conn->error.'</div>';
                }
            }
            $conn->close();
        } 
    }

    else {
        $error = true;
        $error_alert = "Uzupełnij wszystkie pola!";
    }

    if($error == true) {
        echo '<div class="alert alert-danger" role="alert">'.$error_alert.'</div>';
    }
    else {
        echo '<div class="alert alert-success" role="alert">Wygenerowano zamówienie o numerze: '.$orderNumber.'</div>';
    }

    function generateOrderNumber($rok, $uzytkownik2) {
        require('config.php');
        $lastOrderByYear = mysqli_query($conn, "SELECT order_date, order_id FROM orders WHERE RIGHT(order_date,4) = $rok GROUP BY order_date LIMIT 1;");

        if($lastOrderByYear->num_rows == 1 || 0) {
            if($lastOrderByYear->num_rows == 0) {
                $number = 1;
            }
            else {
                $row = mysqli_fetch_assoc($lastOrderByYear);
                $maxOrderId = $row['MAX(order_id)'];

                $lastNameOrder = mysqli_query($conn, "SELECT order_number FROM orders WHERE order_id = $maxOrderId;");
                $row2 = mysqli_fetch_assoc($lastNameOrder);
                
                $maxOrderNumber = $row2['order_number'];
                $number = substr($maxOrderNumber, 4, 3);
                $number++;
                
            }
            $number = str_pad($number, 3, '0', STR_PAD_LEFT);
            $orderNumber = $orderNumber = 'ZAM/'.$number.'/'.$rok.'/'.$uzytkownik2;
            return $orderNumber;
        }
        else {
            $number = 1;
            $number = str_pad($number, 3, '0', STR_PAD_LEFT);
            $orderNumber = $orderNumber = 'ZAM/'.$number.'/'.$rok.'/'.$uzytkownik2;
            return $orderNumber;
        }
    }

    function generateOrderNumber2($liczba2, $rok2,$uzytkownik3) {
        if(empty($liczba2)) {
            $number2 = 1;
        }
        else {
            $number2 = $liczba2;
        }
        $number2 = str_pad($number2, 3, '0', STR_PAD_LEFT);
        $orderNumber2 ='ZAM/'.$number2.'/'.$rok2.'/'.$uzytkownik3;
        return $orderNumber2;
    }

    function getOrderId() {
        require('config.php');
        $lastOrder = mysqli_query($conn, "SELECT order_id FROM orders ORDER BY order_id DESC LIMIT 1;");
        
        $row = mysqli_fetch_assoc($lastOrder);
        $orderId = $row['order_id'];

        return $orderId;
    }
?>