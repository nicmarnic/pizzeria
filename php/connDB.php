<?php

$servername="localhost"; /* nonme del server che spita il DB */
$username= "root"; /* nome utente per accedere al DB */
$password= ""; /* password per accedere al DB */
$dbname= "auth_system"; /* nome del DB */

/* connessione al DB */
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    echo"Connected successfully <br>";
}
?>

