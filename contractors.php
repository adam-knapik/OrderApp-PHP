<?php
    include('config.php');
    include('header.php');
?>
    <?php
        $getContractorsList = mysqli_query($conn, "SELECT * FROM contractors ORDER BY contractor_name;");

        if($getContractorsList->num_rows > 0) { 
                echo '<table id="data-table" class="table table-condensed table-hover table-striped" style="text-align: center">
                <thead>
                    <th>Nazwa</th>
                    <th>Ulica</th>
                    <th>Numer</th>
                    <th>Kod pocztowy</th>
                    <th>Miasto</th>
                    <th>Edycja</th>
                </thead>';

                while($row = $getContractorsList->fetch_assoc()) {
                    if(!empty($row['contractor_premises_number'])) {
                        $number = $row['contractor_building_number']."/".$row['contractor_premises_number'];
                    }
                    else {
                        $number = $row['contractor_building_number'];
                    }
                    echo '<tr>
                        <td text-align="center">'.$row['contractor_name'].'</td>
                        <td>'.$row['contractor_street'].'</td>
                        <td>'.$number.'</td>
                        <td>'.$row['contractor_zip_code'].'</td>
                        <td>'.$row['contractor_city'].'</td>  
                        <td><a href="contractor_edit.php?update_id='.$row["contractor_id"].'"  title="Edytuj"><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button></a></td>
                    </tr>';
                }
            echo "</table>";
        }
        else {
            echo "Brak zamówień do wyświetlenia.";
        }
    ?>
<?php include('footer.php'); ?>