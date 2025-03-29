<?php
session_start();

// 🔐 Vérifie que l'utilisateur est admin
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
  die("Accès interdit.");
}

// ✅ Méthode POST obligatoire
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  die("Méthode non autorisée.");
}

$id = intval($_POST["id"] ?? 0);
$dataFile = "../data/voyages.json";

// 📄 Vérifie si le fichier existe
if (!file_exists($dataFile)) {
  die("Fichier voyages introuvable.");
}

// 🧾 Lire les voyages
$voyages = json_decode(file_get_contents($dataFile), true);

// 🗑️ Supprimer le voyage par ID
$voyages = array_filter($voyages, fn($v) => $v["id"] !== $id);

// 🔁 Réindexer les ID
$voyages = array_values($voyages);
foreach ($voyages as $index => &$v) {
  $v["id"] = $index + 1;
}

// 💾 Sauvegarder
file_put_contents($dataFile, json_encode($voyages, JSON_PRETTY_PRINT));

// 🔁 Redirection vers la liste
header("Location: ../liste_voyage.php?suppr=ok");
exit;
?>

