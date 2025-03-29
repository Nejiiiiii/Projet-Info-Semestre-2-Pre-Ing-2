<?php
session_start();

$dataFile = "data/voyages.json";
$voyages = [];

if (file_exists($dataFile)) {
  $voyages = json_decode(file_get_contents($dataFile), true);
} else {
  die("Fichier des voyages introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Liste des voyages - High WAY</title>
  <link rel="stylesheet" href="css/code.css">
</head>
<body>

  <button onclick="window.location.href='page1.php'" class="home-button">↩️ Accueil</button>

  <header>
    <h1>🌍 Nos voyages disponibles</h1>
  </header>

  <main>
    <div class="flexbox">
      <?php foreach ($voyages as $voyage): ?>
        <ul>
          <li><strong><?= htmlspecialchars($voyage["titre"]) ?></strong></li>
          <li>Destination : <?= htmlspecialchars($voyage["destination"]) ?></li>
          <li>Départ : <?= htmlspecialchars($voyage["date_depart"]) ?></li>
          <li>Retour : <?= htmlspecialchars($voyage["date_retour"]) ?></li>
          <li>Prix : <?= htmlspecialchars($voyage["prix"]) ?> €</li>

          <li class="button-container">
            <a href="voyage_detaille.php?id=<?= $voyage['id'] ?>" class="payment-button">Voir les détails</a>

            <?php if (isset($_SESSION["user"]) && $_SESSION["user"]["role"] === "admin"): ?>
              <a href="modifier_voyage.php?id=<?= $voyage['id'] ?>" class="payment-button">✏️ Modifier</a>

              <form action="traitement/supprimer_voyage.php" method="post" style="display:inline;">
                <input type="hidden" name="id" value="<?= $voyage['id'] ?>">
                <button type="submit" onclick="return confirm('Supprimer ce voyage ?');" class="payment-button">🗑️ Supprimer</button>
              </form>
            <?php endif; ?>
          </li>
        </ul>
      <?php endforeach; ?>
    </div>
  </main>

  <footer>
    <p>© 2025 High WAY. Tous droits réservés.  
    📍 Paris | 📞 +33 1 23 45 67 89 | 📧 contact@HighWAY.fr  
    | Conçu avec 💖 pour pailleter vos vols ✈️</p>
  </footer>

</body

