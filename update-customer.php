<?php
// Initialize the session
session_start();
$id = $_SESSION['id'];

// Tarkistaa onko käyttäjä sisäänkirjautunut. Jos ei ohjaa kirjautumaan.
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require "config.php";

// Prepare an insert statement
$sql = "SELECT asEtunimi, asSukunimi, asOsoite, asPostinro FROM Asiakas WHERE asID = '$id'";
        $resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));		
        $record = mysqli_fetch_assoc($resultset)
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$firstname = $lastname  = $postalcode = $address = "";
$firstname_err = $lastname_err = $postalcode_err = $address_err = "";


    // Defining empty variables

    // Main process starts here
        
        if (isset($_POST['firstname'])) {
            $firstname = filter_var($firstname, FILTER_SANITIZE_STRING);
        }
        if (isset($_POST['lastname'])) {
            $lastname = filter_var($lastname, FILTER_SANITIZE_STRING);
        }
        if (isset($_POST['postalcode'])) {
            $postalcode = filter_var($postalcode, FILTER_SANITIZE_STRING);
        }
        if (isset($_POST['address'])) {
            $address = filter_var($address, FILTER_SANITIZE_STRING);
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

        /*
        // Validate phonenumber
        if(empty(trim($_POST["phonenumber"]))){
            $phonenumber_err = "Please enter a phonenumber.";     
        } elseif(strlen(trim($_POST["phonenumber"])) != 10){
            $phonenumber_err = "phonenumber must have 10 numbers.";
        } else{
            // Prepare a select statement
            $sql = "SELECT asID FROM Asiakas WHERE asPuhnro = ? IF asPuhnro = '$phonenumber'";
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
                        $phonenumber_err = "Tämä puhelinnumero on jo käytössä.";
                    } else{
                        $phonenumber = trim($_POST["phonenumber"]);
                    }
                } else{
                    $phonenumber_err = "Oops! Something went wrong. Please try again later.";
                }
    
                // Close statement
                mysqli_stmt_close($stmt);
            }
        } */
            
    
    
        
        
        // Check input errors before inserting in database
        if(empty($address_err) && empty($postalcode_err) && empty($firstname_err) && empty($lastname_err)){
            
            // Prepare an insert statement
            $sql = "UPDATE `Asiakas` SET `asEtunimi`='$firstname', `asSukunimi`='$lastname',`asOsoite`='$address',`asPostinro`='$postalcode' WHERE asID = '$id'";
         
            if ($link->query($sql) === TRUE) {
              echo "Record updated successfully";
            } else {
              echo "Error updating record: " . $link->error;
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
            <a href="#home" class="nav-link">Päivitä</a>
          </li>
          <li class="nav-item">
            <a href="#explore-head-section" class="nav-link">Tuotteet</a>
          </li>
          <li class="nav-item">
            <button class="btn btn-success"><a href="welcome.php" text="white">Tili</a></button>
          </li>
        </ul>
      </div>
    </div>
  </nav>

<!--- HOME SECTION --->
<header id="home-section">
  <div class="dark-overlay">
    <div class="home-inner container ">
      <div class="row">
        <div class="col-lg-6">
          <div class="card text-center card-form">
            <div class="card-body">
              <h3>Päivitä asiakastiedot</h3>
                <form>
                    <!--<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> -->
                  <div class="form-group">
                  <span position="left">Etunimi</span>
                      <input placeholder="Etunimi" type="text" id="firstname" name="firstname" class="form-control" value="<?php echo $record['asEtunimi']; ?>">
                  </div>
                  <div class="form-group">
                  <span>Sukunimi</span>
                      <input placeholder="Sukunimi" type="text" id="lastname" name="lastname" class="form-control" value="<?php echo $record['asSukunimi']; ?>">
                  </div>     
                  <div class="form-group">
                  <span>Postiosoite</span>
                      <input placeholder="Postiosoite" type="text" id="address" name="address" class="form-control" value="<?php echo $record['asOsoite']; ?>">
                  </div>
                  <div class="form-group">
                  <span>Postinumero</span>
                      <input placeholder="Postinumero" type="text" id="postalcode" name="postalcode" class="form-control" value="<?php echo $record['asPostinro']; ?>">
                  </div>      
                  <span id="update-status"></span>   
                  <div class="form-group">       
                      <input id="btnUpdateInfo" class="btn btn-dark" value="Päivitä" data-toggle="modal" data-target="#status-modal">
                  </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-lg-6 d-none d-lg-block">
          <h1 class="display-4">Tarvitsetko <strong>apua?</strong></h1>
          <div class="d-flex">
            <div class="p-4 align-self-start">
              <i class="fas fa-check fa-2x"></i>
            </div>
            <div class="p-4 align-self-end">
              Ota yhteyttä asiakaspalveluumme!<br>
              <br>Sähköposti: comaelectronix@gmail.com
              <br>Puhelin: 0440441251 (9-17 arkisin)
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


          $sql = "SELECT tuoteID, tuoteNimi, tuoteHinta, tuoteKuvaus, tuoteKuvaPath, tuoteArvosana FROM Tuote ORDER BY tuoteID DESC LIMIT 5";
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
            <div class="card-rating">
                <?php /*

                // adding gold stars to product
                $ratingdecimal = $record['tuoteArvosana'];
                if ($ratingdecimal >= 0.50) {
                  $rating = round($ratingdecimal, 0, PHP_ROUND_HALF_UP);
                  for($i=0; $i < $rating; $i++) {
                      
                  ?>
                  <i class="fa fa-star" style="color:gold"></i>
                  <?php }

                  // adding the missing white stars
                  if ($rating < 5) {
                    $x = 5 - $rating; 
                    for($i=0; $i < $x; $i++) {
                      
                  ?>
                  <i class="fa fa-star"></i>
                    <?php }}} 

                    // If Rating is 0, add 5 white stars
                    else {
                    ?>
                    <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                    <?php }*/?>
            </div>
            <div class="mt-auto">
              <p class="card-product-id" value="<?php echo $record['tuoteID']; ?>">ID: <?php echo $record['tuoteID']; ?></p>
              <button id="btnAddIntoCart" class="btn btn-outline-light btn-block">Lisää koriin</button>
            </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>
</section>


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
        <button onClick="window.location.reload();" type="button" class="btn btn-success" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

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
  <script src="update-customer.js"></script>
</body>

</html>