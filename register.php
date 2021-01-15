<?php
require "config.php";
 
// Defining empty variables
$email = $firstname = $lastname = $phonenumber = $postalcode = $address = $password = $confirm_password = "";
$email_err = $firstname_err = $lastname_err = $phonenumber_err = $postalcode_err = $address_err = $password_err = $confirm_password_err = "";
 
// Main process starts here
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    } elseif(strlen(trim($_POST["email"])) < 6){
        $email_err = "Email must have atleast 6 characters.";
    } else{
        // Prepare a select statement
        $sql = "SELECT asID FROM Asiakas WHERE asSposti = ?";
        $email_err = "";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This username is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 8){
        $password_err = "Password must have atleast 8 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate firstname
    if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter a firstname.";     
    } elseif(strlen(trim($_POST["firstname"])) < 2){
        $firstname_err = "Firstname must have atleast 2 characters.";
    } else{
        $firstname = trim($_POST["firstname"]);
    }

    // Validate lastname
    if(empty(trim($_POST["lastname"]))){
        $lastname_err = "Please enter a lastname.";     
    } else{
        $lastname = trim($_POST["lastname"]);
    }
    
    // Validate postalcode
    if(empty(trim($_POST["postalcode"]))){
        $postalcode_err = "Please enter a postalcode.";     
    } elseif(strlen(trim($_POST["postalcode"])) != 5){
        $postalcode_err = "Postalcode must have 5 characters.";
    } else{
        $postalcode = trim($_POST["postalcode"]);
    }      
    
    // Validate address
    if(empty(trim($_POST["address"]))){
        $address_err = "Please enter a address.";     
    } elseif(strlen(trim($_POST["address"])) < 4){
        $address_err = "Address must have atleast 4 characters.";
    } else{
        $address = trim($_POST["address"]);
    }     

    // Validate phonenumber
    if(empty(trim($_POST["phonenumber"]))){
        $phonenumber_err = "Please enter a phonenumber.";     
    } elseif(strlen(trim($_POST["phonenumber"])) != 10){
        $phonenumber_err = "phonenumber must have 10 numbers.";
    } else{
        // Prepare a select statement
        $sql = "SELECT asID FROM Asiakas WHERE asPuhnro = ?";
        $phonenumber_err = "";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_phonenumber);
            
            // Set parameters
            $param_phonenumber = trim($_POST["phonenumber"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // store result
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $phonenumber_err = "This phonenumber is already in use.";
                } else{
                    $phonenumber = trim($_POST["phonenumber"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
        


    
    
    // Check input errors before inserting in database
    if(empty($email_err) && empty($password_err) && empty($confirm_password_err) &&  empty($address_err) && empty($postalcode_err) && empty($phonenumber_err) && empty($firstname_err) && empty($lastname_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO Asiakas (asEtunimi, asSukunimi, asOsoite, asPostinro, asPuhnro, asSposti, asSalasana) VALUES (?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_firstname, $param_lastname, $param_address, $param_postalcode, $param_phonenumber, $param_email, $param_password);
            
            // Set parameters
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_email = $email;
            $param_address = $address;
            $param_postalcode = $postalcode;
            $param_phonenumber = $phonenumber;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Rekisteröidy</h2>
        <p>Täytä lomake rekisteröityäksesi.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                <label>Etunimi</label>
                <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
                <span class="help-block"><?php echo $firstname_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                <label>Sukunimi</label>
                <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
                <span class="help-block"><?php echo $lastname_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Sähköposti</label>
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>       
            <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                <label>Osoite</label>
                <input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
                <span class="help-block"><?php echo $address_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($postalcode_err)) ? 'has-error' : ''; ?>">
                <label>Postinumero</label>
                <input type="text" name="postalcode" class="form-control" value="<?php echo $postalcode; ?>">
                <span class="help-block"><?php echo $postalcode_err; ?></span>
            </div>      
            <div class="form-group <?php echo (!empty($phonenumber_err)) ? 'has-error' : ''; ?>">
                <label>Puhelinnumero</label>
                <input type="text" name="phonenumber" class="form-control" value="<?php echo $phonenumber; ?>">
                <span class="help-block"><?php echo $phonenumber_err; ?></span>
            </div>        
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Onko sinulla jo tili? <a href="login.php">Kirjaudu</a>.</p>
        </form>
    </div>    
</body>
</html>