<?php
require "config.php";
// Main process starts here

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Defining empty variables
  $feedback_name = $feedback = $feedback_email = "";
  $feedback_name_err = $feedback_err = $feedback_email_err = "";
  
  // Main process starts here
      
      if (isset($_POST['feedback_name'])) {
          $feedback_name = filter_var($feedback_name, FILTER_SANITIZE_STRING);
      }
      if (isset($_POST['feedback_email'])) {
          $feedback_email = filter_var($feedback_email, FILTER_SANITIZE_STRING);
      }
      if (isset($_POST['feedback'])) {
          $feedback = filter_var($feedback, FILTER_SANITIZE_STRING);
      } else {
          exit();
      }
  
      // Validate email
      if(empty(trim($_POST["feedback_email"]))){
          $feedback_email_err = "Please enter an email.";
      } elseif(strlen(trim($_POST["feedback_email"])) < 6){
          $feedback_email_err = "Email must have atleast 6 characters.";
      } else{
          $feedback_email = trim($_POST["feedback_email"]);
      }
  
      // Validate name
      if(empty(trim($_POST["feedback_name"]))){
          $feedback_name_err = "Please enter a name.";     
      } elseif(strlen(trim($_POST["feedback_name"])) < 2){
          $feedback_name_err = "Name must have atleast 2 characters.";
      } else{
          $feedback_name = trim($_POST["feedback_name"]);
      }
      

      // Validate feedback
      if(empty(trim($_POST["feedback_name"]))){
        $feedback_name_err = "Please enter feedback.";     
    } elseif(strlen(trim($_POST["feedback_name"])) < 2){
        $feedback_name_err = "Feedback must have at least 5 characters";
    } else{
        $feedback = trim($_POST["feedback"]);
    }      
               
      // Check input errors before inserting in database
      if(empty($feedback_name_err) && empty($feedback_email_err) && empty($feedback_err)){
          
          // Prepare an insert statement
          $sql = "INSERT INTO Palaute (palauteNimi, palauteSposti, palaute) VALUES (?, ?, ?)";
           
          if($stmt = mysqli_prepare($link, $sql)){
  
              // Bind variables to the prepared statement as parameters
              mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_email, $param_feedback);
              
              // Set parameters
              $param_name = $feedback_name;
              $param_feedback = $feedback;
              $param_email = $feedback_email;
              
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