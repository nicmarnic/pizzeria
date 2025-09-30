<?php
include 'connDB.php';

$sql = "SELECT id, username, email FROM users";
$result = $conn->query($sql);

echo "<h2>Lista utenti registrati</h2>";

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>ID</th><th>Username</th><th>Email</th></tr>";

    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['username']}</td>
                <td>{$row['email']}</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "Nessun utente trovato.";
}

$conn->close();
?>
