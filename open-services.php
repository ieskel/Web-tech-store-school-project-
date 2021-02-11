

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
      <div class="services">
        <!--
        <button class="btn btn-secondary dropdown-toggle" type="button" id="order-history-dropdown-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Valitse huolto
        </button>
        <div id="order-history-dropdown" class="dropdown-menu" aria-labelledby="order-history-dropdown-button"></div>
       -->
       <div id="services" class="form-select form-select-lg mb-3" aria-label="Default select example">
        <select id="open-services-dropdown">
        </select>
      </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <div class="card text-center card-form">
            <div class="card-body">
              <h3>Keskeneräiset huollot</h3>
              <form>
                <div class="form-group">
                  <span>Hinta</span>
                  <input placeholder="Huollon hinta. Valitse listasta huolto" disabled type="text" id="huoltoHinta" class="form-control">
                </div>
                <div class="form-group">
                  <span>Huollon kuvaus</span>
                    <input placeholder="Huollon kuvaus. Valitse listasta huolto" disabled type="text" id="huoltoKuvaus" class="form-control">
                </div>
                <div class="form-group">
                  <span>Varausaika</span>
                  <input placeholder="Lasku varausaika. Valitse listasta huolto" disabled type="text" id="huoltoVarausAika" class="form-control">
                </div>      
                <div class="form-group">
                  <span>Lisätakuu</span>
                  <input placeholder="Huollon lisätakuu. Valitse listasta huolto" disabled type="text" id="huoltoLisatakuu" class="form-control">
                </div> 
                <div class="form-group">
                  <span>Kuljetuspalvelu</span>
                  <input placeholder="Kuljetuspalvelu? Valitse listasta huolto" disabled type="text" id="huoltoKuljetuspalvelu" class="form-control">
                </div>
                <div class="form-group">       
                  <input id="btn-delete-service" class="btn btn-dark" value="Peruuta huolto" data-toggle="modal" data-target="#status-modal">
                </div>
                <div><p style="color:white;font-size:20px" id="delete-status"></p></div>  
                <p style="color:white;font-size:15px" color="gray">*Huollon voi ainoastaan peruuttaa jos sen varauksesta on alle 30 minuuttia.</p> 
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

<!--- EXPLORE HEAD --->
<section id="explore-head-section">
  <div class="container">
    <div class="card-deck">
      <?php
      require "config.php";
  
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

  
<!---FOOTER--->
<footer id="main-footer" class="bg-dark">
  <div class="container">
    <div class="row">
      <div class="col text-center py4">
        <h3>Coma Electronix Oy <br>
        <i class="fas fa-copyright"></i>
        <span id="footer-year"></span></h3>
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
    
    

    // sets the current year into the page footer
    document.getElementById("footer-year").innerHTML = new Date().getFullYear();
  </script>
  <script src="open-services.js"></script>
</body>

</html>