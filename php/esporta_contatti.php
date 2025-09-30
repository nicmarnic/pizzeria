<?php
include 'connDB.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="contatti.csv"');

$output = fopen("php://output", "w");
fputcsv($output, ['ID', 'Nome', 'Email', 'Messaggio', 'Data']);

$sql = "SELECT id, nome, email, messaggio, data_invio FROM contatti ORDER BY data_invio DESC";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
$conn->close();
?>
