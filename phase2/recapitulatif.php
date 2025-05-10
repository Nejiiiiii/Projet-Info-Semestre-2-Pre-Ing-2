<?php
session_start();

// Récupération des données personnalisées
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $_SESSION["personnalisation"] = [
    "voyage_id" => $_POST["voyage_id"],
    "nb_personnes" => $_POST["nb_personnes"],
    "hebergement" => $_POST["hebergement"],
    "activites" => $_POST["activites"] ?? [],
    "transport" => $_POST["transport"]
  ];
} elseif (!isset($_SESSION["personnalisation"])) {
  die("Aucune personnalisation détectée.");
}

$donnees = $_SESSION["personnalisation"];
$voyages = json_decode(file_get_contents("data/voyages.json"), true);
$voyage = null;

foreach ($voyages as $v) {
  if ($v["id"] == $donnees["voyage_id"]) {
    $voyage = $v;
    break;
  }
}

if (!$voyage) {
  die("Voyage introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Récapitulatif du voyage</title>
  <link rel="stylesheet" href="css/code.css">
</head>
<body>
  <button onclick="window.location.href='voyage_detaille.php?id=<?= $voyage["id"] ?>'" class="home-button">✏️ Modifier</button>

  <header>
    <h1>🧳 Récapitulatif de votre voyage personnalisé</h1>
  </header>

  <main>
    <div class="flexbox">
      <ul>
        <li><strong>Voyage :</strong> <?= htmlspecialchars($voyage["titre"]) ?></li>
        <li><strong>Destination :</strong> <?= htmlspecialchars($voyage["destination"]) ?></li>
        <li><strong>Dates :</strong> <?= $voyage["date_depart"] ?> → <?= $voyage["date_retour"] ?></li>
        <li><strong>Nombre de personnes :</strong> <?= $donnees["nb_personnes"] ?></li>
        <li><strong>Hébergement :</strong> <?= ucfirst($donnees["hebergement"]) ?></li>
        <li><strong>Transport :</strong> <?= ucfirst($donnees["transport"]) ?></li>
        <li><strong>Activités :</strong>
          <ul>
            <?php foreach ($donnees["activites"] as $a): ?>
              <li><?= htmlspecialchars($a) ?></li>
            <?php endforeach; ?>
          </ul>
        </li>
      </ul>

      <div class="button-container">
        <a href="paiement.php" class="payment-button">Payer ce voyage 💳</a>
      </div>
    </div>
  </main>

  <footer>
    <p>© 2025 High WAY. Tous droits réservés.</p>
  </footer>

  $tarifs = json_decode(file_get_contents("data/tarifs.json"), true); // Charge les tarifs qui sont dans data en json

  
</body>
</html>
