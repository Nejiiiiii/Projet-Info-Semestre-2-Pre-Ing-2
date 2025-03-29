<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
  die("Accès interdit.");
}

$dataFile = "../data/voyages.json";

// Lire les données existantes
$voyages = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

// Nouveau voyage
$newVoyage = [
  "id" => count($voyages) + 1,
  "titre" => $_POST["titre"] ?? "",
  "destination" => $_POST["destination"] ?? "",
  "date_depart" => $_POST["date_depart"] ?? "",
  "date_retour" => $_POST["date_retour"] ?? "",
  "prix" => floatval($_POST["prix"] ?? 0),
  "description" => $_POST["description"] ?? "",
  "options" => array_map('trim', explode(",", $_POST["options"] ?? "")),
  "image" => $_POST["image"] ?? ""
];

// Ajouter au tableau et enregistrer
$voyages[] = $newVoyage;
file_put_contents($dataFile, json_encode($voyages, JSON_PRETTY_PRINT));

// Retour à la liste admin
header("Location: ../page7.php?ajout=ok");
exit;
?>
