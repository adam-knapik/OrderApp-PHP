<?php
include('config.php');

if(!empty($_GET['order_id'])) {
    $orderId = $_GET['order_id'];

    $order_sql = mysqli_query($conn, "SELECT * FROM orders WHERE order_id = '$orderId' LIMIT 1;");

    if($order_sql->num_rows == 1) {
        $row_order = mysqli_fetch_assoc($order_sql);

        $txtOrderNumber = $row_order['order_number'];
        $txtOrderValueNet = $row_order['order_value_net'];
        $txtOrderDesination = $row_order['order_destination'];
        $txtOrderPaymentMethod = $row_order['order_payment_method'];
        $txtOrderDeliveryDate = $row_order['order_delivery_date'];
        $txtOrderDelivery = $row_order['order_delivery'];
        $txtOrderDate = date('d.m.Y', strtotime($row_order['order_date']));
        $txtOrderNote = $row_order['order_note'];
        $txtOrderType = $row_order['order_type'];

        $rowOrderContractor = $row_order['order_contractor'];
        $rowOrderUser = $row_order['order_user'];
        $rowOrderCompany = $row_order['order_company'];

        if(!empty($rowOrderContractor)) {
            $contractor_sql = mysqli_query($conn, "SELECT * FROM contractors WHERE contractor_id = '$rowOrderContractor' LIMIT 1;");
            $row_contractor = mysqli_fetch_assoc($contractor_sql);

            $txtContractorName = $row_contractor['contractor_name'];
            $txtContractorStreet = $row_contractor['contractor_street'];
            $txtContractorBuilding = $row_contractor['contractor_building_number'];
            $txtContractorPremises = $row_contractor['contractor_premises_number'];
            $txtContractorZipCode = $row_contractor['contractor_zip_code'];
            $txtContractorCity = $row_contractor['contractor_city'];

            if(!empty($txtContractorPremises)) {
                $txtContractorlAddressNumber = $txtContractorBuilding."/".$txtContractorPremises;
            }
            else {
                $txtContractorlAddressNumber = $txtContractorBuilding; 
            }
        }

        if(!empty($rowOrderUser)) {
            $user_sql = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$rowOrderUser' LIMIT 1;");
            $row_user = mysqli_fetch_assoc($user_sql);

            $txtUserName = $row_user['user_name'];
            $txtUserSurname = $row_user['user_surname'];
            $txtUserEmail = $row_user['user_email'];
            $txtUserOffice = $row_user['user_office'];
            $txtUserMobile = $row_user['user_mobile'];
        }

        if(!empty($rowOrderCompany)) {
            $company_sql = mysqli_query($conn, "SELECT * FROM company_details WHERE detail_id = $rowOrderCompany LIMIT 1");
            $row_company = mysqli_fetch_assoc($company_sql);

            $txtCompanyShortName = $row_company['detail_shortname'];
            $txtCompanyName = $row_company['detail_name'];
            $txtCompanyStreet = $row_company['detail_street'];
            $txtCompanyBuilding = $row_company['detail_building_number'];
            $txtCompanyPremises = $row_company['detail_premises_number'];
            $txtCompanyZipCode = $row_company['detail_zip_code'];
            $txtCompanyCity = $row_company['detail_city'];

            if(!empty($txtCompanyPremises)) {
                $txtCompanyAddressNumber = $txtCompanyBuilding."/".$txtCompanyPremises;
            }
            else {
                $txtCompanyAddressNumber = $txtCompanyBuilding; 
            }
        }
    }
}


//php ini gd odkomentować
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();
ob_start();
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        *{ 
            font-family: DejaVu Sans; 
            font-size: 12px;
        }
        body {
            padding-top: 70px;
            padding-bottom: 50px;
        }
        .header {
            height: 60px;
            width: 100%;
            position: fixed;
            top: 0;
        }
        .header img {
            height: 50px; 
            float: left;  
        }
        .header p {
            text-align: right;
        }
        .footer {
            width: 100%;
            height: 50px;
            position: fixed;
            bottom: 0;
            text-align: center;
            font-size: 8px;
        }
        .page-break {
            page-break-before: always;
        }
        .red-bar {
            width: 100%;
            height: 10px;
            background-color: red;
        }
        .content {
            width: 100%;
        }
        .contractor {
            text-align: right;
        }
        .contractor p {
            font-size: 14px;
            font-weight: bold;
        }
        .indentation {
            margin-left: 15px;
        }
        .order-spec {
            text-align: center;
        }
        .order-spec p {
            text-align: left;
        }
        .bold {
            font-weight: bold;
        }
        h1 {
            font-size: 19px;
        }
        .tb-order-spec {
            width: 100%;
            text-align: center;
        }
        .tb-order-spec, .th-order-spec, .td-order-spec {
            border: 1px solid black;
            border-collapse: collapse;  
        }
        .tb-order-total {
            width: 30%;
	    margin-top: 5px;
            margin-left: auto;
            margin-right: 0;
            text-align: center;
        }
        .tb-order-total, .th-order-total {
            border: 1px solid black;
            border-collapse: collapse;   
        }
        .th-order-total {
            width: 50%;
        }
        .tb-order-info {
            width: 100%;
            text-align: center;
        }
        .td-order-info {
            width: 50%;
            text-align: left;
        }
        /*
        .tb-order-info, .td-order-info {
            border: 1px solid black;
            border-collapse: collapse;   
        }
        */
    </style>
    <title><?php echo $txtOrderNumber; ?></title>
</head>
<body> 
    <div class="header">
        <img src="img/logo.png">
        <p>
            Data zamówienia: <?php echo $txtOrderDate; ?><br>
            Przeznaczenie: <?php echo $txtOrderDesination; ?>
        </p>
        <div class="red-bar"></div>
    </div>
    <div class="content">

        <div class="contractor">
            <p><br>
                <?php echo $txtContractorName; ?><br>
                <?php echo $txtContractorStreet." ".$txtContractorlAddressNumber; ?><br>
                <?php echo $txtContractorZipCode." ".$txtContractorCity; ?><br>
            </p>
        </div>

        <div class="order-spec">
            <h1>ZAMÓWIENIE <?php echo $txtOrderNumber; ?></h1>

            <table class="tb-order-spec">
                <tr>
                    <th width="10%" class="th-order-spec">Lp.</th>  
                    <th width="45%" class="th-order-spec"><?php echo $txtOrderType; ?></th>
                    <th width="15%" class="th-order-spec">Cena</th>
                    <th width="15%" class="th-order-spec">Ilość</th>
                    <th width="15%" class="th-order-spec">Wartość</th>  
                </tr>
                <?php
                    if(!empty($_GET['order_id'])) {
                        $item_sql = mysqli_query($conn, "SELECT * FROM order_items WHERE item_order_id = '$orderId';");
                        if($item_sql->num_rows > 0) {
                            $count = 1;
                            while($row_item = $item_sql->fetch_assoc()) {
                                echo "<tr><td class='td-order-spec'>".$count."</td><td class='td-order-spec'>".$row_item['item_name']."</td><td class='td-order-spec'>".$row_item['item_price']." PLN</td><td class='td-order-spec'>".$row_item['item_quantity']."</td><td class='td-order-spec'>".$row_item['item_subtotal']." PLN</td></tr>";
                                $count++;
                            }
                        }
                    }
                ?>
            </table>

            <table class="tb-order-total">
                <tr>
                    <th class="th-order-total">Razem netto:</th>
                    <th class="th-order-total"><?php echo $txtOrderValueNet." PLN"; ?></th>
                </tr>
            </table>

            <br>
            
            <table class="tb-order-info">
                <tr>
                    <td class="td-order-info">
                        <?php if(!empty($txtOrderPaymentMethod)) { echo "<span class='bold'>Forma płatności:</span> ".$txtOrderPaymentMethod; } ?><br>
                        <?php if(!empty($txtOrderDeliveryDate)) { echo "<span class='bold'>Termin "; if($txtOrderType == "Usługa") { echo "wykonania usługi"; } else { echo "dostawy" ;} echo ":</span> ".$txtOrderDeliveryDate; } ?><br>
                        <?php if(!empty($txtOrderDelivery)) { if($txtOrderType != "Usługa") {echo "<span class='bold'>Dostawa:</span> ".$txtOrderDelivery."<br>"; }} ?>
                        <span class="bold">Adres <?php if($txtOrderType == "Usługa") { echo "wykonania usłgui:";} else { echo "dostawy: "; }?></span><br>
                            <span class="indentation"><?php echo $txtCompanyName; ?></span><br>
                            <span class="indentation"><?php echo $txtCompanyStreet. " ".$txtCompanyAddressNumber; ?></span><br>
                            <span class="indentation"><?php echo $txtCompanyZipCode." ".$txtCompanyCity; ?></span><br>

                        <?php if(!empty($txtOrderNote)) { echo "<span class='bold'>Notatka:</span> ".$txtOrderNote; } ?><br>
                    </td>
                    <td class="td-order-info"></td>
                </tr>
                <tr>
                    <td class="td-order-info">
                        <span class="bold">Dane do faktury:</span><br>
                            <span class="indentation">Hurtownia</span><br>
                            <span class="indentation">Miła 1</span><br>
                            <span class="indentation">60-543 Poznań</span><br>
                            <span class="indentation">NIP: 111-11-11-111</span><br>

                        <span class="bold">Zamówienie sporządzone przez:</span><br>
                            <?php echo $txtUserName." ".$txtUserSurname; ?><br>
                            <?php echo "E-mail: ".$txtUserEmail; ?><br>
                            <?php if(!empty($txtUserOffice)) echo "Office: ".$txtUserOffice; ?><br>
                            <?php if(!empty($txtUserMobile)) echo "Mobile: ".$txtUserMobile; ?><br>
                        </td>
                    <td class="td-order-info">
                    </td>
                </tr>
            </table>

        </div>

    </div>
    <div class="footer">
        <div class="red-bar"></div>
    </div>
</body>
</html>

<?php

$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
$html = ob_get_clean();

$txtOrderNumber2 = str_replace('/', '.', $txtOrderNumber);
$orderFileName = 'Order_'.$txtOrderNumber2.'.pdf';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($orderFileName, array("Attachment" => 0));
?>