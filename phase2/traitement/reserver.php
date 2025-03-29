<?php
session_start();
if (!isset($_SESSION["user"])) {
  header("Location: ../page5.php?erreur=Connexion requise");
  exit;
}

$userId = $_SESSION["user"]["id"];
$voyageId = intval($_POST["voyage_id"] ?? 0);

if (!$voyageId) {
  die("ID de voyage invalide.");
}

$dataFile = "../data/reservations.json";
$reservations = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

$reservations[] = [
  "user_id" => $userId,
  "voyage_id" => $voyageId,
  "date" => date("Y-m-d H:i:s")
];

file_put_contents($dataFile, json_encode($reservations, JSON_PRETTY_PRINT));

header("Location: ../page6.php?success=reservation");
exit;
?>
