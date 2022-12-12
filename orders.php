<?php
    include('config.php');
    include('header.php');

    $userId = $_SESSION['id'];
?>
    <?php
        $getOrderList = mysqli_query($conn, "SELECT * FROM orders WHERE order_user = $userId ORDER BY order_number DESC, order_id DESC;");

        if($getOrderList->num_rows > 0) { 
                echo "<table id='data-table' class='table table-condensed table-hover table-striped' style='text-align: center'>
                <thead>
                    <th>Numer zamówienia</th>
                    <th>Kontrahent</th>
                    <th>Wartość</th>
                    <th>Data</th>
                    <th>Drukuj</th>
                    <th>Edycja</th>
                    <th>Usuń</th>
                </thead>";

                while($row = $getOrderList->fetch_assoc()) {
                    $orderDate = date("d.m.Y", strtotime($row["order_date"]));
                    
                    $idContractor = $row["order_contractor"];
                    $getOrderContractor = mysqli_query($conn, "SELECT contractor_name FROM contractors WHERE contractor_id='$idContractor'  LIMIT 1;");

                    if($getOrderContractor->num_rows == 1 ) {
                        $row2 = mysqli_fetch_assoc($getOrderContractor);
                        $nameContractor = $row2["contractor_name"];
                    }

                    echo '<tr>
                        <td>'.$row["order_number"].'</td>
                        <td>'.$nameContractor.'</td>
                        <td>'.$row["order_value_net"].' PLN</td>
                        <td>'.$orderDate.'</td>
                        <td><a href="order_print.php?order_id='.$row["order_id"].'"  target="_blank" title="PDF"><button class="btn btn-primary btn-sm"><i class="fa fa-print"></i></button></a></td>
                        <td><a href="order_edit.php?update_id='.$row["order_id"].'"  title="Edytuj"><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button></a></td>
                        <td><a href="order_delete.php?order_id='.$row['order_id'].'" title="Usuń"><button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></a></td>
                    </tr>';
                }
            echo "</table>";
        }
        else {
            echo "Brak zamówień do wyświetlenia.";
        }
    ?>
<?php include('footer.php'); ?>