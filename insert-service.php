<?php
session_start();
  
  
$id = $_SESSION['id'];
  
require "config.php";
  
  
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
      // Main process starts here
          if (isset($_POST['huoltoHinta'])) {
              $huoltoHinta = filter_var($huoltoHinta, FILTER_SANITIZE_STRING);
              $huoltoHinta = $_POST["huoltoHinta"];
          }
          if (isset($_POST['huoltoVarausAika'])) {
              $huoltoVarausAika = filter_var($huoltoVarausAika, FILTER_SANITIZE_STRING);
              $huoltoVarausAika = trim($_POST["huoltoVarausAika"]);
          }
          if (isset($_POST['huoltoVarausKommentti'])) {
            $huoltoVarausKommentti = filter_var($huoltoVarausKommentti, FILTER_SANITIZE_STRING);
            $huoltoVarausKommentti = trim($_POST["huoltoVarausKommentti"]);            
          }
          if (isset($_POST['huoltoLisatakuu'])) {
            $huoltoLisatakuu = filter_var($huoltoLisatakuu, FILTER_SANITIZE_STRING);
            $huoltoLisatakuu = $_POST["huoltoLisatakuu"]; 
    
          }
          if (isset($_POST['huoltoKuljetuspalvelu'])) {
            $huoltoKuljetuspalvelu = filter_var($huoltoKuljetuspalvelu, FILTER_SANITIZE_STRING);
            $huoltoKuljetuspalvelu = $_POST["huoltoKuljetuspalvelu"];
     
          }
          //if ($huoltoHinta == $huoltoHinta_verify) {
                      
          
              // Prepare an insert statement
              $sql = "INSERT INTO `Huolto`(huoltoKuljetuspalvelu,huoltoVarausKommentti, huoltoLisatakuu, huoltoVarausAika, ttID, huoltoHinta, asID)
                      VALUES ('$huoltoKuljetuspalvelu','$huoltoVarausKommentti', '$huoltoLisatakuu', '$huoltoVarausAika', 0, $huoltoHinta, $id)";
           
              if ($link->query($sql) === TRUE) {
                $response = "Huolto varattu päivämäärälle: `$huoltoVarausAika`";
                
              } else {
                $response = "Ongelma lisäyksessä " . $link->error;
              }
  
              echo json_encode($response);
  
          // Close connection
          //}

          mysqli_close($link);
          
}
?>