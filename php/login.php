<?php
session_start(); /* inizializza la sessione */
include 'connDB.php'; /* include il file di connessione al DB */

if ($_SERVER['REQUEST_METHOD']=='POST'){
    $username = $_POST['username']; /* prende il valore inserito nel campo username */
    $password = $_POST['password']; /* prende il valore inserito nel campo password */

    /* controlla se l'utente esiste nel DB */

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    /*$conn->prepare() prepara la query SQL per essere eseguita 
      restistuisce un oggetto con la query per recuperare l'username.
      "?" è un segnaposto per il valore che verrà passato alla query
       */
    $stmt->bind_param("s", $username);
    /*$stmt->bind_param() associa i valori ai segnaposti della query
      "s" indica che il valore è una stringa
      */
    $stmt->execute(); /* esegue la query */
    $stmt->store_result(); /* memorizza il risultato della query Utile
                              per num_rows  */

    if ($stmt->num_rows > 0){
        $stmt->bind_result($id, $username,$hashed_password);
        $stmt->fetch();
        /*
        ID USERNAME PASSWORD
        1  admin      $2y$10$1
        2  user       $2y$10$2
        */

        /*$stmt->bind_result() associa le variabili ai risultati della query
          $id, $username, $hashed_password sono le variabili che conterranno i risultati
          della query
          */
        if(password_verify($password, $hashed_password)){
            $_SESSION["user_id"] = $id; /* memorizza l'id dell'utente */
            $_SESSION["username"] = $username; /* memorizza l'username dell'utente */

            header("location: home.php"); /* reindirizza alla pagina di benvenuto */
            exit();
        }else{
            echo "password errati";
        }
    }else{
        echo "username non trovato";
    }

    $stmt->close(); /* chiude la query */
    $conn->close(); /* chiude la connessione al DB */


}

?>