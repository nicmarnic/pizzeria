<?php
include 'connDB.php';

$sql = "SELECT id, nome, email, messaggio, data_invio FROM contatti ORDER BY data_invio DESC";
$result = $conn->query($sql);

echo "<h2>📬 Messaggi ricevuti</h2>";

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='10'>";
    echo "<tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Messaggio</th>
            <th>Data</th>
          </tr>";

    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nome']}</td>
                <td>{$row['email']}</td>
                <td>{$row['messaggio']}</td>
                <td>{$row['data_invio']}</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "Nessun contatto trovato.";
}

$conn->close();
?>
