<?php
session_start();
require "config.php";
?>
 
 <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
    crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
    crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <title>Coma Electronix</title>
</head>
  <!-- Sivuston määrittely alkaa tästä -->
<body data-spy="scroll" data-target="#main-nav" id="home">
  <nav class="navbar navbar-expand-sm navbar-dark fixed-top" id="main-nav" >
    <div class="container">
      <a href="frontpage.php" class="navbar-brand">Coma Electronix</a>
      <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a href="#home" class="nav-link">Koti</a>
          </li>
          <li class="nav-item">
            <a href="#explore-head-section" class="nav-link">Tuotteet</a>
          </li>
          <li class="nav-item">
          <button class="btn btn-success"><a href="login.php" text="white"><?php if(isset($_SESSION['id'])) {
              
              ?>Tili</a></button>
            </li>
            <?php } else {
                  ?>Kirjaudu</a></button>
            <?php } ?>
        </ul>
      </div>
    </div>
  </nav>

<!--- HOME SECTION --->
<header id="home-section">
  <div class="dark-overlay">
    <div class="home-inner container ">
      <div class="row">
        <div class="col-lg-6 d-none d-lg-block">
          <h1 class="display-4">Huollamme <strong>sinun</strong> elektroniikan</h1>
          <div class="d-flex">
            <div class="p-4 align-self-start">
              <i class="fas fa-check fa-2x"></i>
            </div>
            <div class="p-4 align-self-end">
              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Omnis, voluptatibus. Unde alias omnis neque quia?
            </div>
          </div>
          <div class="d-flex">
            <div class="p-4 align-self-start">
              <i class="fas fa-check fa-2x"></i>
            </div>
            <div class="p-4 align-self-end">
              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Omnis, voluptatibus. Unde alias omnis neque quia?
            </div>
          </div>
          <div class="d-flex">
            <div class="p-4 align-self-start">
              <i class="fas fa-check fa-2x"></i>
            </div>
            <div class="p-4 align-self-end">
              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Omnis, voluptatibus. Unde alias omnis neque quia?
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="card text-center card-form">
            <div class="card-body">
              <h3>Rekisteröidy</h3>
              <form>
            <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                <input placeholder="Etunimi" type="text" id="register-firstname" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
            </div>
            <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                <input placeholder="Sukunimi" type="text" id="register-lastname" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
            </div>
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <input placeholder="Sähköposti" type="email" id="register-email" name="email" class="form-control" value="<?php echo $email; ?>">
            </div>       
            <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                <input placeholder="Postiosoite" type="text" id="register-address" name="address" class="form-control" value="<?php echo $address; ?>">
            </div>
            <div class="form-group <?php echo (!empty($postalcode_err)) ? 'has-error' : ''; ?>">
                <input placeholder="Postinumero" type="text" id="register-postalcode" name="postalcode" class="form-control" value="<?php echo $postalcode; ?>">
            </div>      
            <div class="form-group <?php echo (!empty($phonenumber_err)) ? 'has-error' : ''; ?>">
                <input placeholder="Puhelinnumero" type="text" id="register-phonenumber" name="phonenumber" class="form-control" value="<?php echo $phonenumber; ?>">
            </div>        
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <input placeholder="Salasana" type="password" id="register-password" name="password" class="form-control" value="<?php echo $password; ?>">
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <input placeholder="Vahvista salasana" type="password" id="register-confirm_password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
            </div>
            <div class="form-group">
                <input id="btnRegister" class="btn btn-secondary" value="Rekisteröidy" data-toggle="modal" data-target="#status-modal">
                <input id="btnResetRegister" type="reset" class="btn btn-default" value="Tyhjennä">
            </div>
            <p> <a href="login.php"> Onko sinulla jo tili? Kirjaudu tästä</a>.</p>
        </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>

<!--- EXPLORE HEAD --->
<section id="explore-head-section">
<div class="container">
<div class="card-deck">
<?php


			$sql = "SELECT tuoteID, tuoteNimi, tuoteHinta, tuoteKuvaus, tuoteKuvaPath, tuoteArvosana FROM Tuote ORDER BY tuoteID DESC LIMIT 5 ";
            $resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));		
			for($x = 0; $x < 5; $x++) {
                $record = mysqli_fetch_assoc($resultset)

            //comment lower comment out for infinite product list & replace for loop
            //while($record = mysqli_fetch_assoc($resultset)) {
                
			?>
  <div class="card" style="overflow: hidden; background: #474B4F;" >
    <a href="product.php?id=<?php echo $record['tuoteID']; ?>"><img style="display: block; height: 150px; width: auto;" class="mx-auto d-block" class="card-img-top" class="rounded" src="<?php echo $record['tuoteKuvaPath'];?>" alt="img/create-section.jpeg"></a>
    <div class="card-body d-flex flex-column" style="background: #6b6e70;">
      <h4 class="card-title"><a href="product.php?id=<?php echo $record['tuoteID']; ?>"><?php echo $record['tuoteNimi']; ?></a></h4>
      <h5 class="card-price"><?php echo $record['tuoteHinta']; ?> €</h5>
      <p class="card-text"><?php echo utf8_encode($record['tuoteKuvaus']); ?></p>
	  <div class="mt-auto">
      <p class="card-product-id" value="<?php echo $record['tuoteID']; ?>">ID: <?php echo $record['tuoteID']; ?></p>
      <a href="product.php?id=<?php echo $record['tuoteID']; ?>"><button class="btn btn-outline-light btn-block">Osta</button></a> 
	  </div>
    </div>
  </div>
<?php } ?>
</div>
</section>

<!---FOOTER--->
<footer id="main-footer" class="bg-dark">
  <div class="container">
    <div class="row">
      <div class="col text-center py4">
        <h3>Coma Electronix Oy <br>
        <i class="fas fa-copyright"></i> <?php echo date("Y"); ?></h3>
        <button class="btn btn-success" data-toggle="modal" data-target="#contactModal">
          Anna palautetta
        </button>
      </div>
    </div>
  </div>
</footer>

<!-- REGISTER MODAL --->
<div class="modal" tabindex="-1" role="dialog" id="status-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="color:black">Tila</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p style="color:black" id="modal-text"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal" >OK</button>
      </div>
    </div>
  </div>
</div>

<!---CONTACT MODAL --->
<div class="modal fade text-dark" id="contactModal" method="post">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Anna palautetta</h5>
        <button class="close fas fa-times" data-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="name">Nimi</label>
            <input id="feedback-name" name="feedback_name" placeholder="Nimi" type="text" class="form-control">
            <span id="help-block-feedback-name" class="help-block"></span>
          </div>
          <div class="form-group">
            <label for="email">Sähköposti</label>
            <input id="feedback-email" name="feedback_email" placeholder="Sähköposti" type="email" class="form-control">
            <span id="help-block-feedback-email" class="help-block"></span>
          </div>
          <div class="form-group">
            <label for="message">Palaute</label>
            <textarea name="feedback" placeholder="Palaute" id="feedback" class="form-control"></textarea>
            <span id="help-block-feedback" class="help-block"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button id="btnSubmitFeedback" class="btn btn-success btn-block">Submit</button>
        <span id="feedback-success" class="help-block"></span>
      </div>
    </div>
  </div>
</div>


  <!-- Sivuston määrittely päättyy tähän -->

  <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
    crossorigin="anonymous"></script>

  <script>
    //initialize ScrollSpy
    $('body').scrollspy({target: '#main-nav'});
    

    //smooth scrolling
    $("#main-nav a").on('click', function (event) {
      if (this.hash !== "") {
        event.preventDefault();
        const hash = this.hash;

        $('html, body').animate({
          scrollTop: $(hash).offset().top
        }, 800, function () {
          window.location.hash = hash;
        });
      }
    });
  </script>
  <script src="register.js"></script>
  <script src="feedback.js"></script>
</body>

</html>


<?php
require "config.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Defining empty variables
$email = $firstname = $lastname = $phonenumber = $postalcode = $address = $password = $confirm_password = "";
$email_err = $firstname_err = $lastname_err = $phonenumber_err = $postalcode_err = $address_err = $password_err = $confirm_password_err = "";

// Main process starts here
    
    if (isset($_POST['firstname'])) {
        $firstname = filter_var($firstname, FILTER_SANITIZE_STRING);
    }
    if (isset($_POST['lastname'])) {
        $lastname = filter_var($lastname, FILTER_SANITIZE_STRING);
    }
    if (isset($_POST['email'])) {
        $email = filter_var($email, FILTER_SANITIZE_STRING);
    }
    if (isset($_POST['phonenumber'])) {
        $phonenumber = filter_var($phonenumber, FILTER_SANITIZE_STRING);
    }
    if (isset($_POST['postalcode'])) {
        $postalcode = filter_var($postalcode, FILTER_SANITIZE_STRING);
    }
    if (isset($_POST['address'])) {
        $address = filter_var($address, FILTER_SANITIZE_STRING);
    }
    if (isset($_POST['password'])) {
        $password = filter_var($password, FILTER_SANITIZE_STRING);
    }
    if (isset($_POST['confirm_password'])) {
        $confirm_password = filter_var($confirm_password, FILTER_SANITIZE_STRING);
    }

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
                    $email_err = "This email is already taken.";
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
    $lastname = trim($_POST["lastname"]);
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
                echo "OK";
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