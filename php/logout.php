<?php 


session_start(); /*inizializza la sessionee */
session_destroy(); /*distrugge la sessione */
header("Location../login.html");
exit();


?>