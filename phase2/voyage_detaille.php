<?php
session_start();

// Vérifie que l'ID est fourni
if (!isset($_GET['id'])) {
  header("Location: liste_voyage.php");
  exit;
}

$id = intval($_GET['id']);
$dataFile = "data/voyages.json";

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

// Charger les commentaires
$commentsFile = "data/commentaires.json";
$commentaires = file_exists($commentsFile) ? json_decode(file_get_contents($commentsFile), true) : [];
$avis = array_filter($commentaires, fn($c) => $c["voyage_id"] == $voyage["id"]);
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
        <?php if (isset($_SESSION["user"])): ?>
          <form action="traitement/reserver.php" method="post">
            <input type="hidden" name="voyage_id" value="<?= $voyage['id'] ?>">
            <button type="submit" class="payment-button">📩 Réserver ce voyage</button>
          </form>
        <?php else: ?>
          <p><a href="page5.php" class="payment-button">Connectez-vous pour réserver</a></p>
        <?php endif; ?>
      </div>
    </div>

    <?php if (isset($_SESSION["user"])): ?>
      <div class="flexbox">
        <h2>💬 Laisser un commentaire</h2>
        <form action="traitement/commentaire.php" method="post">
          <input type="hidden" name="voyage_id" value="<?= $voyage["id"] ?>">
          <textarea name="message" rows="4" placeholder="Votre commentaire..." required></textarea><br>
          <div class="button-container">
            <button type="submit" class="payment-button">Envoyer ✉️</button>
          </div>
        </form>
      </div>
    <?php endif; ?>

    <div class="flexbox">
      <h2>🗨️ Avis des utilisateurs</h2>
      <?php if (empty($avis)): ?>
        <p>Aucun avis pour ce voyage.</p>
      <?php else: ?>
        <?php foreach ($avis as $c): ?>
          <div class="review-item">
            <div>
              <strong><?= htmlspecialchars($c["user"]) ?></strong>
              <small style="display:block; color: #ccc;">🕒 <?= date("d/m/Y H:i", strtotime($c["date"])) ?></small>
              <p><?= nl2br(htmlspecialchars($c["message"])) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

  </main>

  <footer>
    <p>© 2025 High WAY. Tous droits réservés.  
    📍 Paris | 📞 +33 1 23 45 67 89 | 📧 contact@HighWAY.fr  
    | Conçu avec 💖 pour pailleter vos vols ✈️</p>
  </footer>

</body>
</html>
