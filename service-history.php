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
        $sql = "SELECT * FROM Huolto INNER JOIN Lasku ON Lasku.HuoltoID = Huolto.HuoltoID WHERE Huolto.asID = :asID";
        
        $database = $link->prepare($sql);
        // nimetylle parametrille annetaan tässä arvo (arvo vaihtuu, käyttäjän antaman arvon mukaan)
        $database->bindValue(':asID', $asID);
        $database->execute();
      
        $errorInfo = $database->errorInfo();
        // executen jälkeen haun tulokset siirretään fetchAll-komennolla muuttujaan $data
        $data = $database->fetchAll(PDO::FETCH_ASSOC);
        if (empty($data)){
        // lähetetään Ajax response: joko virheilmoitus tai jos löytyi, niin asiakastieto 
        // jos $data on tyhjä, niin haettua asiakasta ei löytynyt
          $return['huoltoID']  = "Asiakkuudella ei ole huoltoja";
          echo json_encode($return);
        }
        else{ 

          echo json_encode($data);
        } 
      } 
      catch(PDOException $message) {
          $errorInfo = $message->getMessage();
          $return['huoltoID']  = $errorInfo;
          // lähetetään Ajax response: virheilmoitus
          echo json_encode($return);
      }
    
}
else
{
  // tässä tapauksessa phpkoodiin tullaan väärää reittiä
  $return['huoltoID'] = "Jokin meni pieleen";
  // lähetetään Ajax response: virheilmoitus
  echo json_encode($return);
}
?>