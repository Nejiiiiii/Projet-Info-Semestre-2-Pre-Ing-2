<?php
session_start();

// 🔐 Sécurité admin
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
  die("Accès interdit.");
}

// 📥 ID du voyage
$id = intval($_GET["id"] ?? 0);
if (!$id) {
  header("Location: liste_voyage.php");
  exit;
}

// 📄 Charger les données
$dataFile = "data/voyages.json";
if (!file_exists($dataFile)) {
  die("Fichier voyages introuvable.");
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
  <title>Modifier un voyage</title>
  <link rel="stylesheet" href="css/code.css">
</head>
<body>

  <header>
    <h1>✏️ Modifier le voyage</h1>
    <button onclick="window.location.href='liste_voyage.php'" class="home-button">↩️ Retour</button>
  </header>

  <main>
    <div class="flexbox">
      <form action="traitement/modifier_voyage.php" method="post">
        <input type="hidden" name="id" value="<?= $voyage["id"] ?>">

        <input type="text" name="titre" value="<?= htmlspecialchars($voyage["titre"]) ?>" required><br>
        <input type="text" name="destination" value="<?= htmlspecialchars($voyage["destination"]) ?>" required><br>
        <input type="date" name="date_depart" value="<?= $voyage["date_depart"] ?>" required><br>
        <input type="date" name="date_retour" value="<?= $voyage["date_retour"] ?>" required><br>
        <input type="number" name="prix" value="<?= $voyage["prix"] ?>" required><br>
        <textarea name="description" rows="4" required><?= htmlspecialchars($voyage["description"]) ?></textarea><br>
        <input type="text" name="options" value="<?= implode(', ', $voyage["options"] ?? []) ?>"><br>
        <input type="text" name="image" value="<?= htmlspecialchars($voyage["image"]) ?>"><br>

        <div class="button-container">
          <button type="submit" class="payment-button">✅ Enregistrer</button>
        </div>
      </form>
    </div>
  </main>

  <footer>
    <p>© 2025 High WAY. Tous droits réservés.</p>
  </footer>

</body>
</html>
