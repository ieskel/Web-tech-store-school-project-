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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  
      // Defining empty variables
  
      // Main process starts here
          
          if (isset($_POST['huoltoID'])) {
              $huoltoID = filter_var($huoltoID, FILTER_SANITIZE_STRING);
              $huoltoID = trim($_POST["huoltoID"]);
          }
          

          $query= mysqli_query($link,"SELECT huoltoID, huoltoValmis, TIMESTAMPDIFF(MINUTE,huoltoVarausAika, CURRENT_TIMESTAMP) AS DiffMinute FROM Huolto HAVING huoltoValmis = 0 AND DiffMinute < 30 AND huoltoID = '$huoltoID'");
          if(mysqli_num_rows($query) > 0){

              $row=mysqli_fetch_array($query, MYSQLI_ASSOC); // fetch the data
              $query= mysqli_query($link,"DELETE FROM Huolto WHERE huoltoID='$huoltoID'");
              $response="Huolto poistettu!";

          } else {

              $response= "Huolto on varattu yli 30 minuuttia sitten. Asiakaspalvelu voi auttaa asiassa.";

          }

          echo json_encode($response);
          
          // Close connection
          mysqli_close($link);
}

?>