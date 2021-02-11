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
            <a href="#home" class="nav-link">Varaa</a>
          </li>
          <li class="nav-item">
            <a href="#explore-head-section" class="nav-link">Tuotteet</a>
          </li>
          <li class="nav-item">
          <a href="welcome.php" text="white"><button class="btn btn-success">Tili</button></a>
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
              <h3>Varaa huolto</h3>
                <form>
                    <!--<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> -->
                  <div class="form-group">
                  <div>
                      <p>Kommentti (min 10, max 255 merkkiä)</p>
                      <input type="textarea" minlength="10" maxlength="255" id="reserve-comment">
                    </div>   
                    <div>
                      <p>Lisätakuu? (+25 €, ei pakollinen)</p>
                      <input type="checkbox" value="on" id="reserve-extra-warranty">
                    </div>
                    <div>
                      <p>Kuljetuspalvelu? (+25 €, ei pakollinen)</p>
                      <input type="checkbox" value="on" id="reserve-delivery">
                    </div>
                  </div>
                  <div>
                      <p>Valitse päivä (Jos et valitse, nykyinen päivämäärä tulee ajaksi)</p>
                      <input type="date" id="reserve-date" min="2021-02-11" max="">
                    </div>
                  <div class="form-group">       
                      <br><input id="btnReserveService" class="btn btn-dark" value="Varaa" data-toggle="modal" data-target="#status-modal">
                  </div>
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
        <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
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
    //set min date for new service
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    if(dd<10){
            dd='0'+dd
        } 
        if(mm<10){
            mm='0'+mm
        } 

    today = yyyy+'-'+mm+'-'+dd;
    document.getElementById("reserve-date").setAttribute("min", today);

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
</body>

</html>