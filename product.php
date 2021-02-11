<?php
session_start();
require "config.php";

$uri = $_SERVER['REQUEST_URI'];

 
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$productid = substr($url, -2);

$query = $_SERVER['QUERY_STRING'];

$sql = "SELECT tuoteID, tuoteNimi, tuoteHinta, tuoteKuvaus, tuoteKuvaPath, kategoriaID, valmistajaID, tuoteArvosana FROM Tuote WHERE tuoteID = '$productid'";
            $resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));		
            $record = mysqli_fetch_assoc($resultset)

?>
<?php 

$valmistajaID = $record['valmistajaID'];

            $sql2 = "SELECT valmistajaNimi FROM Valmistaja WHERE valmistajaID = '$valmistajaID'";
            $resultset2 = mysqli_query($link, $sql2) or die("database error:". mysqli_error($link));		
            $record2 = mysqli_fetch_assoc($resultset2)
?>
<?php 

$kategoriaID = $record['kategoriaID'];

            $sql3 = "SELECT kategoriaNimi FROM Laitekategoria WHERE kategoriaID = '$kategoriaID'";
            $resultset3 = mysqli_query($link, $sql3) or die("database error:". mysqli_error($link));		
            $record3 = mysqli_fetch_assoc($resultset3)
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
  <title>Coma Electronix - <?php echo $record['tuoteNimi'] ?></title>
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
          <a href="login.php" text="white"><button class="btn btn-success"><?php if(isset($_SESSION['id'])) {
              
            ?>Tili</button></a>
          </li>
          <?php } else {
                ?>Kirjaudu</a></button>
          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>



<div class="justify-content-center" style="margin-top: 100px;" class="container-fluid">
    <div  class="content-wrapper">
    <p style="color:gray" class="card-product-path">> <?php echo utf8_encode($record3['kategoriaNimi']);?> > <?php echo utf8_encode($record['tuoteNimi']); ?></p>	
		<div class="item-container">	
			<div class="container">	
				<div class="col-md-12">
					<div class="product col-md-3 service-image-left">
						<center>
							<img style="height: 250px;" id="item-display" src="<?php echo $record['tuoteKuvaPath'];?>" alt="img/create-section.jpeg"></img>
						</center>
					</div>
				</div>
					
				<div class="col-md-7">
          <br>
					<div class="product-title" style="font-size: 25px;"><?php echo utf8_encode($record['tuoteNimi']) ?></div>
          <div class="product-price" style="font-size: 22px;"><?php echo $record['tuoteHinta'] ?> €</div>
          <div class="product-desc" style="font-size: 18px;"><?php echo utf8_encode($record['tuoteKuvaus']) ?></div>

          <hr style="background: #FFF;">
          <div class="product-manufacturer" style="font-size: 15px;">Valmistaja: <?php echo utf8_encode($record2['valmistajaNimi']) ?></div>
          <div class="product-category" style="font-size: 15px;">Kategoria: <?php echo utf8_encode($record3['kategoriaNimi']) ?></div>          
					<!-- <div class="product-stock" style="color: #74DF00; font-size: 20px; margin-top: 10px;">In Stock</div> -->
					<hr style="background: #FFF;">

            <div class="mt-auto">
                <div class="product-rating">
              <?php 

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
                  <?php }?>
              </div>
              <p   style="color:gray" class="card-product-id" value="<?php echo $record['tuoteID']; ?>">ID: <?php echo $record['tuoteID']; ?></p>	 
              <button type="button" class="btn btn-success">
                Lisää koriin
              </button> 
            </div>
				</div>
			</div> 
		</div>
										  
						</div>
				</div>
				<hr>
			</div>
		</div>
	</div>
</div>

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
              <button id="btnAddIntoCart" class="btn btn-outline-light btn-block">Lisää koriin</button>
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
        <i class="fas fa-copyright"></i> <?php echo date("Y"); ?></h3>
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
  <script src="cart.js"></script>
</body>

</html>