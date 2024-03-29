<?php
// Initialize the session
session_start();

// Tarkistaa onko käyttäjä sisäänkirjautunut. Jos ei ohjaa kirjautumaan.
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$id = $_SESSION['id'];

require "config.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Main process starts here
        $hinta = 50;

        if (isset($_POST['huoltoKuljetusPalvelu'])) {
            $huoltoKuljetusPalvelu = filter_var($huoltoKuljetusPalvelu, FILTER_SANITIZE_STRING);
            $huoltoKuljetusPalvelu = trim($_POST["huoltoKuljetusPalvelu"]);
            $hinta = $hinta + 25;
        }
        if (isset($_POST['huoltoLisatakuu'])) {
            $huoltoLisatakuu = filter_var($huoltoLisatakuu, FILTER_SANITIZE_STRING);
            $huoltoLisatakuu = trim($_POST["huoltoLisatakuu"]);
            $hinta = $hinta + 25;
        }
        if (isset($_POST['huoltoVarausAika'])) {
            $huoltoVarausAika = filter_var($huoltoVarausAika, FILTER_SANITIZE_STRING);
            $huoltoVarausAika = trim($_POST["huoltoVarausAika"]);
            
        }
        
        
            // Prepare an insert statement
            $sql = "INSERT INTO `Huolto`(`huoltoKuljetuspalvelu`, `huoltoLisatakuu`, huoltoVarausAika, ttID, huoltoHinta, asID) VALUES ($huoltoKuljetusPalvelu,$huoltoLisatakuu, $huoltoVarausAika, 0, $hinta, $id)";
         
            if ($link->query($sql) === TRUE) {
              $response ="Huoltovaraus lisätty!";
              
            } else {
              $response ="Ongelma lisäyksessä " . $link->error;
            }

            echo json_encode($response);

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
            <a href="#home" class="nav-link">Tilitoiminnot</a>
          </li>
          <li class="nav-item">
            <a href="#explore-head-section" class="nav-link">Tuotteet</a>
          </li>
          <li class="nav-item">
          <a href="logout.php" text="white"><button class="btn btn-success">Kirjaudu ulos</button></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

<!--- HOME SECTION --->
<header id="home-section">
    <div class="dark-overlay">
        <div class="home-inner container" style="margin-top: 5rem">
            <div class="row" >
                        <div class="card text-center" style="margin-left: 5rem; background: #5cb85c ;">
                        <h4 >Varaa, peru ja osta</h4>

                                <div class="card-body">
                                    <a href="reserve-service.php" class="btn btn btn-outline-light btn-secondary">Varaa huolto</a>
                                </div>
                                <div class="card-body">
                                    <a href="open-services.php" class="btn btn btn-outline-light btn-secondary">Avoimet huollot</a>
                                </div>
                        </div>
                        <div class="card text-center" style="margin-left: 5rem;  background: #5cb85c ;">
                            <h4>Historia</h4>
                                <div class="card-body">
                                    <a href="order-history.html" class="btn btn btn-outline-light btn-secondary">Tilaushistoria</a>
                                </div>
                                <div class="card-body">
                                    <a href="service-history.html" class="btn btn btn-outline-light btn-secondary">Huoltohistoria</a>
                                </div>
                        </div>
                        <div class="card text-center" style="margin-left: 5rem; background: #5cb85c ;">
                            <h4>Päivitä</h4>
                                <div class="card-body">
                                    <a href="update-customer.php" class="btn btn btn-outline-light btn-secondary">Päivitä asiakastietoja</a>
                                </div>
                                <div class="card-body">
                                    <a href="reset-password.php" class="btn btn btn-outline-light btn-secondary">Vaihda salasana</a>
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
              <p class="card-product-id" style="color:lightgray" value="<?php echo $record['tuoteID']; ?>">ID: <?php echo $record['tuoteID']; ?></p>
              <a href="product.php?id=<?php echo $record['tuoteID']; ?>"><button class="btn btn-outline-light btn-block">Osta</button></a>     
            </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>
</section>


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
  <script src="reserve-service.js"></script>
  <script src="feedback.js"></script>
</body>

</html>