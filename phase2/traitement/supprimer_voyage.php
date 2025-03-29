<?php
session_start();

// Vérifie que l'utilisateur est un admin
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
  die("Accès interdit.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $id = intval($_POST["id"] ?? 0);
  $dataFile = "../data/voyages.json";

  if (!file_exists($dataFile)) {
    die("Fichier introuvable.");
  }

  $voyages = json_decode(file_get_contents($dataFile), true);
  $voyages = array_filter($voyages, fn($v) => $v["id"] != $id);

  // Réindexer les ID (optionnel)
  $voyages = array_values($voyages);
  foreach ($voyages as $index => &$v) {
    $v["id"] = $index + 1;
  }

  file_put_contents($dataFile, json_encode($voyages, JSON_PRETTY_PRINT));
  header("Location: ../liste_voyage.php?suppr=ok");
  exit;
}

echo "Méthode non autorisée.";
?>
