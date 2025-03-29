<?php
// Charger les voyages
$dataFile = "../data/voyages.json";
$voyages = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

// Récupération des filtres
$destination = strtolower(trim($_GET["destination"] ?? ""));
$date_depart = $_GET["date_depart"] ?? "";
$date_retour = $_GET["date_retour"] ?? "";
$option = $_GET["option"] ?? "all";

// 🔍 Filtrer les voyages
$resultats = array_filter($voyages, function ($v) use ($destination, $date_depart, $date_retour, $option) {
  $ok = true;

  if ($destination && strpos(strtolower($v["destination"]), $destination) === false) {
    $ok = false;
  }

  if ($date_depart && $v["date_depart"] < $date_depart) {
    $ok = false;
  }

  if ($date_retour && $v["date_retour"] > $date_retour) {
    $ok = false;
  }

  if ($option !== "all" && (!isset($v["options"]) || !in_array($option, $v["options"]))) {
    $ok = false;
  }

  return $ok;
});
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Résultats de recherche</title>
  <link rel="stylesheet" href="../css/code.css">
</head>
<body>

  <button onclick="window.location.href='../page1.php'" class="home-button">↩️ Accueil</button>

  <header>
    <h1>🔎 Résultats de votre recherche</h1>
  </header>

  <main>
    <div class="flexbox">
      <?php if (empty($resultats)): ?>
        <p>Aucun voyage ne correspond à vos critères.</p>
      <?php else: ?>
        <?php foreach ($resultats as $voyage): ?>
          <ul>
            <li><strong><?= htmlspecialchars($voyage["titre"]) ?></strong></li>
            <li>Destination : <?= htmlspecialchars($voyage["destination"]) ?></li>
            <li>Dates : <?= $voyage["date_depart"] ?> → <?= $voyage["date_retour"] ?></li>
            <li>Prix : <?= $voyage["prix"] ?> €</li>
            <li>
              <a href="../voyage_detaille.php?id=<?= $voyage["id"] ?>" class="payment-button">Voir détails</a>
            </li>
          </ul>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </main>

  <footer>
    <p>© 2025 High WAY. Tous droits réservés. 📍 Paris | 📧 contact@HighWAY.fr ✈️</p>
  </footer>

</body>
</html>
