<?php
    include('config.php');
    include('header.php');
?>
    <script src="js/createOrder.js"></script>

    <form action="#" method="POST" class="order-form" id="order-form" role="form" novalidate="" onsubmit="return false">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <label id="lb-company" for="company">Adres dostawy:*</label>
                    <?php
                        $select_company = mysqli_query($conn, "SELECT detail_id, detail_shortname FROM company_details;");

                        if($select_company->num_rows > 0) {
                            echo '<select name="company" id="company" class="form-control">';
                            while($row = $select_company->fetch_assoc()) {
                                echo "<option value='$row[detail_id]'>".$row['detail_shortname']."</option>";
                            }
                            echo "</select>"; 
                        }
                        else {
                            echo "Brak miejsc dostawy!";
                        }
                    ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <label for="contractor">Kontrahent:*</label>
                <?php
                    $select_contractors = mysqli_query($conn, "SELECT contractor_id, contractor_name FROM contractors;");

                    if($select_contractors->num_rows > 0) {
                        echo '<select name="contractor" id="contractor" class="form-control">';
                        while($row = $select_contractors->fetch_assoc()) {
                            echo "<option value='$row[contractor_id]'>".$row['contractor_name']."</option>";
                        }
                        echo "</select>"; 
                    }
                    else {
                        echo "Brak kontrahentów!";
                    }
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <script src="js/selectType.js"></script>
                <label for="type">Typ:*</label>
                    <?php
                        $select_type = mysqli_query($conn, "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'orders' AND COLUMN_NAME = 'order_type';");
                        $row = mysqli_fetch_array($select_type);
                        $type_list = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE'])-6))));

                        echo '<select name="type" id="type" class="form-control" onchange="changeSelectType(value);">';
                        for($i=0; $i < count($type_list); $i++) {
                            echo "<option value='$type_list[$i]'>".$type_list[$i]."</option>";
                        }
                        echo'</select>';
                    ?>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-3">
                <label id="lb-no-zam" for="nozam">Numer zamówienia:* (tylko liczba)</label>
                    <input type="number" class="form-control" id="number" name="nozam" placeholder="1">
            </div>
            <div class="form-group col-md-3">
                <label id="lb-delivery-date" for="order_date">Data zamówienia:*</label>
                    <input id="datepicker2" name="order_date" placeholder="dd-mm-yyyy">
                <script src="js/datepicker2.js"></script>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <table class="table table-condensed table-striped" id="orderItem">
                    <tr>
                        <th id="th-product" width="53%">Produkt*</th>
                        <th width="15%">Cena [PLN]*</th>
                        <th width="15%">Ilość*</th>
                        <th width="15%">Wartość [PLN]*</th>
                        <td width="2%"></th>
                    </tr>
                    <tr id="show_item">
                        <td><input type="text" name="product_name[]" id="productName_1" class="form-control"></td>
                        <td><input type="number" name="product_price[]" id="price_1" class="form-control"></td>
                        <td><input type="number" name="product_quantity[]" id="qty_1" class="form-control"></td>
                        <td><input type="number" name="product_total[]" id="total_1" class="form-control" readonly></td>
                        <td><button class="btn btn-success add_item_btn">Dodaj</button></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="form-group mt-3 mb-3 ">
                    <label>Razem:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text currency">PLN</span>
                            </div>
                            <input value="" type="text" class="form-control" name="sub_total" id="sub_total" placeholder="Razem"><!-- readonly -->
                        </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <label for="destination">Przeznaczenie:*</label>
                <?php
                    $select_destination = mysqli_query($conn, "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'orders' AND COLUMN_NAME = 'order_destination';");
                    $row = mysqli_fetch_array($select_destination);
                    $destination_list = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE'])-6))));

                    echo '<select name="destination" id="destination" class="form-control">';
                    for($i=0; $i < count($destination_list); $i++) {
                        echo "<option value='$destination_list[$i]'>".$destination_list[$i]."</option>";
                    }
                    echo'</select>';
                ?>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <label for="payment">Metoda zapłaty:*</label>
                <?php
                    $select_payment = mysqli_query($conn, "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'orders' AND COLUMN_NAME = 'order_payment_method';");
                    $row = mysqli_fetch_array($select_payment);
                    $payment_list = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE'])-6))));

                    echo '<select name="payment" id="payment" class="form-control">';
                    for($i=0; $i < count($payment_list); $i++) {
                        echo "<option value='$payment_list[$i]'>".$payment_list[$i]."</option>";
                    }
                    echo'</select>';
                ?>
            </div>
        </div>

        <div id="row-delivery" class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <label for="delivery">Dostawa:*</label>
                <?php
                    $select_delivery = mysqli_query($conn, "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'orders' AND COLUMN_NAME = 'order_delivery';");
                    $row = mysqli_fetch_array($select_delivery);
                    $delivery_list = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE'])-6))));

                    echo '<select name="delivery" id="delivery" class="form-control">';
                        for($i=1; $i < count($delivery_list); $i++) {
                            echo "<option value='$delivery_list[$i]'>".$delivery_list[$i]."</option>";
                        }
                        echo "<option value='$delivery_list[0]' hidden>".$delivery_list[0]."</option>";
                    echo'</select>';
                ?>
            </div>
        </div>

        <div class="row">
        <div class="form-group col-md-3">
                <label id="lb-delivery-date" for="delivery_date">Data dostawy:*</label>
                    <input id="datepicker" name="delivery_date" placeholder="dd-mm-yyyy">
                <script src="js/datepicker.js"></script>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <label for="note">Notatka:</label>
                    <div class="form-group">
                        <textarea class="form-control txt" rows="3" name="note" id="note" placeholder="Notatka do zamówienia"></textarea>
                    </div>
                    <br>
                    <div class="form-group" id="wystaw-btn">
                        <input data-loading-text="Zapisywanie..." type="submit" name="order_btn" value="Wystaw" class="btn btn-success submit_btn order-save-btm" id="add_order_form">           
                    </div>
            </div> 
        </div>
    </form>
    
    <div class="row" id="show_alert"></div>
   
<?php include('footer.php'); ?>