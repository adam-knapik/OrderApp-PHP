<?php
    include('config.php');
    include('header.php');
?>
    <form action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate="">
        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="inputName">Nazwa:*</label>
                <input type="text" class="form-control" id="inputName" name="name">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="inputStreet">Adres:*</label>
                <input type="text" class="form-control" id="inputStreet" name="street">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputBuilding">Numer budynku:*</label>
                <input type="number" class="form-control" id="inputBuidling" name="noBuilding">
            </div>
            <div class="form-group col-md-4">
                <label for="inputPremises">Numer lokalu:</label>
                <input type="number" class="form-control" id="inpuPremises" name="noPremises">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="inputZip">Kod pocztowy:*</label>
                <input type="text" class="form-control" id="inputZip" name="zip">
            </div>
            <div class="form-group col-md-5">
                <label for="inputCity">Miasto:*</label>
                <input type="text" class="form-control" id="inputCity" name="city">
            </div>
        </div>
        <input data-loading-text="Zapisywanie..." type="submit" class="btn btn-primary" value="Dodaj">
    </form>

    <?php
        if(isset($_POST['name'])) {
            $name = $_POST['name'];
            //$nip = $_POST['nip'];
            $street = $_POST['street'];
            $noBuilding = $_POST['noBuilding'];
            $noPremises = $_POST['noPremises'];
            $zip = $_POST['zip'];
            $city = $_POST['city'];

            if(!empty($name) && !empty($street) && !empty($noBuilding) && !empty($zip) && !empty($city)) {
		if(empty($noPremises)) { $noPremises = 0; }
                $insert_contractor = "INSERT INTO contractors (contractor_name, contractor_street, contractor_building_number, contractor_premises_number, contractor_zip_code, contractor_city) VALUES ('$name', '$street', '$noBuilding', '$noPremises', '$zip', '$city')";

                if($conn->query($insert_contractor) === TRUE) {
                    echo '<div class="alert alert-success" role="alert">Dodano kontrahenta '.$name.'</div>';
                }
                else {
                    echo '<div class="alert alert-danger" role="alert">Error: '.$insert_contractor.' '.$conn->error.'</div>';  
                }

                $conn->close();
            }

            else {
                echo '<div class="alert alert-danger" role="alert">Uzupełnij wszystkie pola!</div>';
            }
        }



    ?>

<?php include('footer.php'); ?>