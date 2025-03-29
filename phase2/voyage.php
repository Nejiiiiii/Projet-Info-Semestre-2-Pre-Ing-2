<?php
// Vérifie que l'id du voyage est passé dans l'URL
if (!isset($_GET['id'])) {
  header("Location: liste_voyage.php");
  exit;
}

$id = intval($_GET['id']);
$dataFile = "data/voyages.json";

// Vérifie si le fichier existe
if (!file_exists($dataFile)) {
  die("Fichier voyages introuvable.");
}

$voyages = json_decode(file_get_contents($dataFile), true);

// Recherche du voyage correspondant
$voyage = null;
foreach ($voyages as $v) {
  if ($v["id"] == $id) {
    $voyage = $v;
    break;
  }
}

if (!$voyage) {
  die("Voyage non trouvé.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($voyage["titre"]) ?> - High WAY</title>
  <link rel="stylesheet" href="css/code.css">
</head>
<body>

  <button onclick="window.location.href='liste_voyage.php'" class="home-button">↩️ Retour à la liste</button>

  <header>
    <h1><?= htmlspecialchars($voyage["titre"]) ?></h1>
  </header>

  <main>
    <div class="flexbox">
      <h2>Détails du voyage</h2>
      <ul>
        <li><strong>Destination :</strong> <?= htmlspecialchars($voyage["destination"]) ?></li>
        <li><strong>Date de départ :</strong> <?= htmlspecialchars($voyage["date_depart"]) ?></li>
        <li><strong>Date de retour :</strong> <?= htmlspecialchars($voyage["date_retour"]) ?></li>
        <li><strong>Prix :</strong> <?= htmlspecialchars($voyage["prix"]) ?> €</li>
        <li><strong>Description :</strong><br> <?= nl2br(htmlspecialchars($voyage["description"])) ?></li>
      </ul>
    </div>
  </main>

  <footer>
    <p>© 2025 High WAY. Tous droits réservés.  
    📍 Paris | 📞 +33 1 23 45 67 89 | 📧 contact@HighWAY.fr  
    | Conçu avec 💖 pour pailleter vos vols ✈️</p>
  </footer>

</body>
</html>
