<?php
session_start();

$dataFile = "data/voyages.json";
$voyages = [];

if (file_exists($dataFile)) {
  $voyages = json_decode(file_get_contents($dataFile), true);
} else {
  die("Fichier des voyages introuvable.");
}

// 🔎 Récupérer les filtres GET
$destination = strtolower(trim($_GET["destination"] ?? ""));
$prix_max = floatval($_GET["prix_max"] ?? 0);
$date_min = $_GET["date_min"] ?? "";
$date_max = $_GET["date_max"] ?? "";
$tri = $_GET["tri"] ?? "";

// 🎯 Filtrer
$voyages = array_filter($voyages, function ($v) use ($destination, $prix_max, $date_min, $date_max) {
  $ok = true;

  if ($destination && strpos(strtolower($v["destination"]), $destination) === false) $ok = false;
  if ($prix_max > 0 && floatval($v["prix"]) > $prix_max) $ok = false;
  if ($date_min && $v["date_depart"] < $date_min) $ok = false;
  if ($date_max && $v["date_retour"] > $date_max) $ok = false;

  return $ok;
});

// 🔁 Trier par prix
if ($tri === "asc") {
  usort($voyages, fn($a, $b) => $a["prix"] <=> $b["prix"]);
} elseif ($tri === "desc") {
  usort($voyages, fn($a, $b) => $b["prix"] <=> $a["prix"]);
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
    <!-- 🔽 Tri -->
    <div class="box">
      <form method="get" style="text-align:center;">
        <input type="hidden" name="destination" value="<?= htmlspecialchars($destination) ?>">
        <input type="hidden" name="prix_max" value="<?= htmlspecialchars($prix_max) ?>">
        <input type="hidden" name="date_min" value="<?= htmlspecialchars($date_min) ?>">
        <input type="hidden" name="date_max" value="<?= htmlspecialchars($date_max) ?>">

        <label for="tri">Trier par prix :</label>
        <select name="tri" id="tri">
          <option value="">-- Aucun --</option>
          <option value="asc" <?= $tri === "asc" ? "selected" : "" ?>>⬆️ Croissant</option>
          <option value="desc" <?= $tri === "desc" ? "selected" : "" ?>>⬇️ Décroissant</option>
        </select>
        <button type="submit" class="payment-button">Appliquer</button>
      </form>
    </div>

    <div class="flexbox">
      <?php if (empty($voyages)): ?>
        <p>Aucun voyage trouvé selon vos critères.</p>
      <?php else: ?>
        <?php foreach ($voyages as $voyage): ?>
  <?php
    $duree = (new DateTime($voyage["date_depart"]))->diff(new DateTime($voyage["date_retour"]))->days;
  ?>
  <div class="voyage-item"
       data-prix="<?= $voyage["prix"] ?>"
       data-date="<?= $voyage["date_depart"] ?>"
       data-duree="<?= $duree ?>">
       
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
  </div>
<?php endforeach; ?>

  </main>

  <footer>
    <p>© 2025 High WAY. Tous droits réservés.  
    📍 Paris | 📞 +33 1 23 45 67 89 | 📧 contact@HighWAY.fr  
    | Conçu avec 💖 pour pailleter vos vols ✈️</p>
  </footer>

</body>
</html>
