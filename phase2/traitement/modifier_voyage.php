<?php
session_start();

// 🔐 Vérification administrateur
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
  die("Accès interdit.");
}

// 📄 Fichier JSON
$dataFile = "../data/voyages.json";

// 🔁 Vérifie si méthode POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  die("Méthode non autorisée.");
}

if (!file_exists($dataFile)) {
  die("Fichier voyages introuvable.");
}

$voyages = json_decode(file_get_contents($dataFile), true);
$id = intval($_POST["id"]);
$modifOk = false;

foreach ($voyages as &$voyage) {
  if ($voyage["id"] === $id) {
    $voyage["titre"] = trim($_POST["titre"]);
    $voyage["destination"] = trim($_POST["destination"]);
    $voyage["date_depart"] = $_POST["date_depart"];
    $voyage["date_retour"] = $_POST["date_retour"];
    $voyage["prix"] = floatval($_POST["prix"]);
    $voyage["description"] = trim($_POST["description"]);
    $voyage["options"] = array_filter(array_map("trim", explode(",", $_POST["options"] ?? "")));
    $voyage["image"] = trim($_POST["image"]);
    $modifOk = true;
    break;
  }
}

if ($modifOk) {
  file_put_contents($dataFile, json_encode($voyages, JSON_PRETTY_PRINT));
  header("Location: ../liste_voyage.php?modif=ok");
  exit;
} else {
  die("Voyage non trouvé.");
}
?>

