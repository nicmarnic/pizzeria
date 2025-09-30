<?php
include 'connDB.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="utenti.csv"');

$output = fopen("php://output", "w");
fputcsv($output, ['ID', 'Username', 'Email']);

$sql = "SELECT id, username, email FROM users";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
$conn->close();
?>
