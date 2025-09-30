<?php

// 🔗 1. Connessione al database
$servername = "localhost"; // nome del server
$username = "root";        // nome utente del DB
$password = "";            // password del DB
$dbname = "auth_system";   // nome del database

// Crea connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// 🧼 2. Funzione per pulire i dati input
function pulisci($dato) {
    return htmlspecialchars(trim($dato)); // rimuove spazi, evita codice HTML/JS
}

// 📝 3. Raccolta dei dati inviati dal form
$nome = pulisci($_POST['nome']);
$cognome = pulisci($_POST['cognome']);
$email = pulisci($_POST['email']);
$eta = (int)$_POST['eta'];
$tel = pulisci($_POST['tel']);
$data_nascita = $_POST['data-nascita'];
$sesso = isset($_POST['sesso']) ? $_POST['sesso'] : ''; // evita errori se non selezionato
$messaggio = pulisci($_POST['messaggio']);

// 📁 4. Gestione upload file (curriculum)
$curriculum_path = ''; // Inizialmente la variabile è vuota. Verrà popolata solo se il file viene caricato correttamente.

// ✅ Controlla se è stato inviato un file e che non ci siano errori nel caricamento
if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
    
    $target_dir = "uploads/"; // Cartella in cui salvare i file caricati

    // ✅ Se la cartella non esiste, la crea con permessi completi (lettura/scrittura/esecuzione)
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // true: crea anche cartelle intermedie se necessario
    }

    // ✅ Estrae il nome del file originale (senza percorso) per evitare problemi di sicurezza
    $filename = basename($_FILES["file"]["name"]);

    // ✅ Crea un nome univoco aggiungendo un timestamp al nome del file originale, per evitare conflitti tra file con lo stesso nome
    $target_file = $target_dir . time() . "_" . $filename;

    // 🛡️ (Sicurezza consigliata - NON ancora presente qui, ma utile): verificare estensione, tipo MIME, e dimensione massima

    // ✅ Sposta il file dalla cartella temporanea (dove PHP lo carica inizialmente) alla destinazione definitiva
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $curriculum_path = $target_file; // ✅ Se tutto va bene, salva il percorso del file nella variabile da inviare al DB
    } else {
        echo "Errore nel caricamento del file."; // ❌ Messaggio di errore se qualcosa va storto
    }

} // 🔚 Fine controllo caricamento file


// 💾 5. Inserimento dei dati nel database con Prepared Statement
$sql = "INSERT INTO contatti (nome, cognome, email, eta, tel, data_nascita, sesso, curriculum, messaggio)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Prepara la query
$stmt = $conn->prepare($sql);

// Collega i parametri alla query (s = stringa, i = intero)
$stmt->bind_param("sssisssss", $nome, $cognome, $email, $eta, $tel, $data_nascita, $sesso, $curriculum_path, $messaggio);

// ✅ 6. Esecuzione e risposta all'utente
if ($stmt->execute()) {
    echo "Dati registrati con successo!";
    // Invia email di conferma (opzionale)
  /*   $to = $email;
    $subject = "Conferma ricezione candidatura";
    $message = "Gentile $nome,\n\nLa tua candidatura è stata ricevuta con successo.\n\nCordiali saluti,\nIl team di recruiting.";
    
    (mail($to, $subject, $message)) ?
    echo "Email inviata con successo!" :
    echo "Errore nell'invio dell'email.";   */
    header("location: ../home.html"); // reindirizza alla home page


} else {
    echo "Errore: " . $stmt->error;
}

// 🧹 7. Chiudi statement e connessione
$stmt->close();
$conn->close();

?>
