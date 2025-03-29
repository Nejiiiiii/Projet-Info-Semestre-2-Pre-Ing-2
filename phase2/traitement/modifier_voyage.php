<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
  die("Accès interdit.");
}

$dataFile = "../data/voyages.json";
$voyages = json_decode(file_get_contents($dataFile), true);
$id = intval($_POST["id"]);

foreach ($voyages as &$voyage) {
  if ($voyage["id"] == $id) {
    $voyage["titre"] = $_POST["titre"];
    $voyage["destination"] = $_POST["destination"];
    $voyage["date_depart"] = $_POST["date_depart"];
    $voyage["date_retour"] = $_POST["date_retour"];
    $voyage["prix"] = floatval($_POST["prix"]);
    $voyage["description"] = $_POST["description"];
    $voyage["options"] = array_map("trim", explode(",", $_POST["options"]));
    $voyage["image"] = $_POST["image"];
    break;
  }
}

// Enregistre la modification
file_put_contents($dataFile, json_encode($voyages, JSON_PRETTY_PRINT));

header("Location: ../liste_voyage.php?modif=ok");
exit;
?>
