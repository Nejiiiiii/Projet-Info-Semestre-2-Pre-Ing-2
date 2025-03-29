<?php
session_start();

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION["user"])) {
  header("Location: ../page5.php?erreur=Connexion requise pour commenter");
  exit;
}

$user = $_SESSION["user"];

// Récupération des données POST
$voyageId = intval($_POST["voyage_id"] ?? 0);
$message = trim($_POST["message"] ?? "");

// Validation
if (!$voyageId || empty($message)) {
  die("Données incomplètes.");
}

// Charger les commentaires existants
$dataFile = "../data/commentaires.json";
$commentaires = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

// Créer un nouveau commentaire
$commentaires[] = [
  "voyage_id" => $voyageId,
  "user" => $user["login"],
  "date" => date("Y-m-d H:i:s"),
  "message" => $message
];

// Enregistrer dans le fichier JSON
file_put_contents($dataFile, json_encode($commentaires, JSON_PRETTY_PRINT));

// Redirection vers la page du voyage
header("Location: ../voyage_detaille.php?id=" . $voyageId);
exit;
?>
