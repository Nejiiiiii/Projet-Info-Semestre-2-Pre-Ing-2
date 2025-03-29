<?php
session_start();

// 🔐 Protection admin
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
  die("Accès interdit.");
}

$dataFile = "../data/voyages.json";

// 🔄 Vérifier la méthode
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  die("Méthode non autorisée.");
}

// 🧾 Lire les voyages existants
$voyages = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

// 🆔 Créer un ID unique
$lastId = 0;
foreach ($voyages as $v) {
  if ($v["id"] > $lastId) $lastId = $v["id"];
}
$newId = $lastId + 1;

// 📥 Nouveau voyage
$newVoyage = [
  "id" => $newId,
  "titre" => trim($_POST["titre"] ?? ""),
  "destination" => trim($_POST["destination"] ?? ""),
  "date_depart" => $_POST["date_depart"] ?? "",
  "date_retour" => $_POST["date_retour"] ?? "",
  "prix" => floatval($_POST["prix"] ?? 0),
  "description" => trim($_POST["description"] ?? ""),
  "options" => array_filter(array_map('trim', explode(",", $_POST["options"] ?? ""))),
  "image" => trim($_POST["image"] ?? "")
];

// ✅ Ajouter et sauvegarder
$voyages[] = $newVoyage;
file_put_contents($dataFile, json_encode($voyages, JSON_PRETTY_PRINT));

// 🔁 Retour à l'administration avec message succès
header("Location: ../page7.php?success=1");
exit;
?>
