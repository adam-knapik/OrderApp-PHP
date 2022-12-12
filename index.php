<?php
    session_start();
    
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: orders.php");
        exit;
    }
    require_once "config.php";
    
    $email = $password = "";
    $email_err = $password_err = $login_err = "";
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty(trim($_POST["email"]))){
            $email_err = "Podaj e-mail.";
        } else{
            $email = trim($_POST["email"]);
        }
        
        if(empty(trim($_POST["password"]))){
            $password_err = "Podaj hasło.";
        } else{
            $password = trim($_POST["password"]);
        }
        
        if(empty($email_err) && empty($password_err)){
            $sql = "SELECT user_id, user_name, user_surname, user_shortname, user_email, user_password, user_office, user_mobile FROM users WHERE user_email = ?";
            
            if($stmt = mysqli_prepare($conn, $sql)){
                mysqli_stmt_bind_param($stmt, "s", $param_email);
                $param_email = $email;
                
                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_store_result($stmt);
                    
                    if(mysqli_stmt_num_rows($stmt) == 1){                    
                        mysqli_stmt_bind_result($stmt, $id, $name, $surname, $shortname, $email, $hashed_password, $office, $mobile);

                        if(mysqli_stmt_fetch($stmt)){
                            if($password == $hashed_password){
                                session_start();
                                    $_SESSION["loggedin"] = true;
                                    $_SESSION['id'] = $id;
                                    $_SESSION['name'] = $name;
                                    $_SESSION['surname'] = $surname;
                                    $_SESSION['shortname'] = $shortname;
                                    $_SESSION['email'] = $email;
                                    $_SESSION['office'] = $office;
                                    $_SESSION['mobile'] = $mobile;                           
                                
                                header("location: orders.php");
                            } else{
                                $login_err = "Nieprawidłowy email lub hasło.";
                            }
                        }
                    } else{
                        $login_err = "Nieprawidłowy email lub hasło.";
                    }
                } else{
                    echo "Ups! Coś poszło nie tak spróbouj ponownie później";
                }
                mysqli_stmt_close($stmt);
            }
        }
        mysqli_close($conn);
    }
?>

<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zamówienia</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <style>
        body{ font: 14px sans-serif; }
        .container{ width: 360px; padding: 20px; }
        img { height: 30px; }
    </style>
</head>
<body>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <center><img src="img/logo.png"></center>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Hasło</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <center><input type="submit" class="btn btn-success submit_btn" value="Zaloguj"></center>
            </div>
        </form>
        <?php 
            if(!empty($login_err)){
                echo '<div class="alert alert-danger">' . $login_err . '</div>';
            }        
        ?>
    </div>
</body>
</html>