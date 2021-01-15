<?php
session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.html");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hei, <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b>. Tervetuloa sivuillemme.</h1>
    </div>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Vaihda salasana</a>
        <a href="logout.php" class="btn btn-danger">Kirjaudu ulos</a>
    </p>
</body>
</html>