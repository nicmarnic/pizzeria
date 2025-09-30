<?php

session_start();

if(!isset($_SESSION["user_id"])){ 
    // header("location: ../home.html");    // se è vero che la sessione non esiste invia in 
    header("location: ../lavora_con_noi.html"); 
    exit();                              //  home.html  
}

$username =$_SESSION['username'];         // se è falso che non esiste trova a prendere il valore 
                                        // della sessione username e lo assegna alla variabile $username


?>








<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
</head>
<body>
    <h1>Benvenuto <?php echo $username; ?></h1>
    <a href="logout.php">Logout</a>
    
</body>
</html>