<?php
include "connDB.php";

if($_SERVER['REQUEST_METHOD']=='POST'){
    
    $username= $_POST['username'];
    $email= $_POST['email'];
    $password =password_hash($_POST['password'], PASSWORD_DEFAULT);

    /*visualizza i dati ricevuti nella pagina web*/
    echo"Dati riceviti correttamente <br>";
    echo"Username: $username <br>";
    echo "Email: $email <br>";
    echo "Password: $password <br>";


    $stmt= $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    
    if (!$stmt){
        die ("Errore nelle queri". $conn->error);
    }
    $stmt->bind_param("sss", $username, $email, $password);

    if($stmt->execute()){
        echo "Registrazione avvenuta con successo";
        header("location: ../login.html");
    }else{
        echo "Errore nella registrazione". $stmt->error;
    }

    $stmt->close();
    $conn->close();

}

?>