<?php
session_start();

// Tarkistaa onko käyttäjä sisäänkirjautunut. Jos ei ohjaa kirjautumaan.
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: login.php");
  exit;
}
else {
  $asID = $_SESSION["id"];
}

if (isset($asID)) {
  
  
  // varmistetaan, että htun-tieto on annettu ja jos on, niin lähdetään hakemaan tietoa tietokannasta
      $palvelin = "mysql.cc.puv.fi";
      $username = "e1900909";
      $password = "TYk7ebgwms5Z";
      $charset = 'utf8mb4';
      
      try {
        $errorInfo = "";
  
        $link = new PDO("mysql:host=$palvelin;dbname=e1900909_ComaElectronix;charset=$charset", $username, $password); 
        $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
       
        // hakuLauseessa on vaihtuvan tiedon kohdalla nimetty parametri :htun
        $sql = "SELECT * FROM Huolto HAVING huoltoValmis = 0 AND Huolto.asID = :asID";
        
        $database = $link->prepare($sql);
        $database->bindValue(':asID', $asID);
        $database->execute();
      
        $errorInfo = $database->errorInfo();
        // executen jälkeen haun tulokset siirretään fetchAll-komennolla muuttujaan $data
        $data = $database->fetchAll(PDO::FETCH_ASSOC);
        if (empty($data)){
        // lähetetään Ajax response: joko virheilmoitus tai jos löytyi, niin asiakastieto 
        // jos $data on tyhjä, niin haettua asiakasta ei löytynyt
          $return = "Asiakkuudella ei ole huoltoja";
          echo json_encode($return);
        }
        else{ 

          echo json_encode($data);
        } 
      } 
      catch(PDOException $message) {
          $errorInfo = $message->getMessage();
          $return  = $errorInfo;
          // lähetetään Ajax response: virheilmoitus
          echo json_encode($return);
      }
    
}

else
{
  // tässä tapauksessa phpkoodiin tullaan väärää reittiä
  $return = "Jokin meni pieleen";
  // lähetetään Ajax response: virheilmoitus
  echo json_encode($return);
}


?>