<?php
// Sécurité : on vérifie l'ID du voyage
if (!isset($_GET['id'])) {
  header("Location: liste_voyage.php");
  exit;
}

$id = intval($_GET['id']);
$dataFile = "data/voyages.json";

// Vérifie que le fichier existe
if (!file_exists($dataFile)) {
  die("Fichier des voyages introuvable.");
}

$voyages = json_decode(file_get_contents($dataFile), true);
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
  <title><?= htmlspecialchars($voyage["titre"]) ?> - Détail complet</title>
  <link rel="stylesheet" href="css/code.css">
</head>
<body>

  <button onclick="window.location.href='liste_voyage.php'" class="home-button">↩️ Retour à la liste</button>

  <header>
    <h1><?= htmlspecialchars($voyage["titre"]) ?></h1>
  </header>

  <main>
    <div class="flexbox">
      <h2>✨ Informations détaillées</h2>
      <ul>
        <li><strong>Destination :</strong> <?= htmlspecialchars($voyage["destination"]) ?></li>
        <li><strong>Date de départ :</strong> <?= htmlspecialchars($voyage["date_depart"]) ?></li>
        <li><strong>Date de retour :</strong> <?= htmlspecialchars($voyage["date_retour"]) ?></li>
        <li><strong>Durée :</strong> 
          <?php
            $d1 = new DateTime($voyage["date_depart"]);
            $d2 = new DateTime($voyage["date_retour"]);
            echo $d1->diff($d2)->format('%a jours');
          ?>
        </li>
        <li><strong>Prix :</strong> <?= htmlspecialchars($voyage["prix"]) ?> €</li>
        <li><strong>Description :</strong><br> <?= nl2br(htmlspecialchars($voyage["description"])) ?></li>

        <?php if (isset($voyage["options"])): ?>
          <li><strong>Options incluses :</strong>
            <ul>
              <?php foreach ($voyage["options"] as $option): ?>
                <li>✅ <?= htmlspecialchars($option) ?></li>
              <?php endforeach; ?>
            </ul>
          </li>
        <?php endif; ?>
      </ul>

      <?php if (!empty($voyage["image"])): ?>
        <div class="reviews">
          <img src="images/<?= htmlspecialchars($voyage["image"]) ?>" alt="Image du voyage" class="review-image">
        </div>
      <?php endif; ?>

      <div class="button-container">
        <a href="#" class="payment-button">Réserver ce voyage</a> <!-- À relier plus tard -->
      </div>
    </div>
  </main>

  <footer>
    <p>© 2025 High WAY. Tous droits réservés.  
    📍 Paris | 📞 +33 1 23 45 67 89 | 📧 contact@HighWAY.fr  
    | Conçu avec 💖 pour pailleter vos vols ✈️</p>
  </footer>

</body>
</html>
