<?php

require_once '../includes/dbh.inc.php';

$query = $_GET["query"];

$stmt = $pdo->prepare("SELECT HName FROM hackathon_data WHERE HName LIKE :query");
$stmt->execute(['query' => "%$query%"]);
$suggestions = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo json_encode($suggestions);
?>
