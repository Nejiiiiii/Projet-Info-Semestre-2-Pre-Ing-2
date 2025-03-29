<?php
session_start();

// Vérifie que l'utilisateur est connecté et admin
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
  header("Location: page5.php?erreur=Accès réservé aux administrateurs.");
  exit;
}

$dataFile = "data/utilisateurs.json";
$users = [];

if (file_exists($dataFile)) {
  $users = json_decode(file_get_contents($dataFile), true);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Administration - Utilisateurs</title>
  <link rel="stylesheet" href="css/code.css">
</head>
<body>

  <header>
    <h1>Administration</h1>
    <button onclick="window.location.href='page1.php'" class="home-button">Retour à l'accueil ↩️</button>
  </header>

  <main>
    <div class="flexbox">
      <h2>Liste des Utilisateurs</h2>

      <?php foreach ($users as $user): ?>
        <ul>
          <li><strong><?= htmlspecialchars($user["login"]) ?></strong></li>
          <li>Email : <?= htmlspecialchars($user["email"]) ?></li>
          <li>Rôle : <?= htmlspecialchars($user["role"]) ?></li>
          <li>
            <div class="button-container">
              <!-- Formulaire pour passer en VIP -->
              <form action="traitement/admin_action.php" method="post" style="display:inline;">
                <input type="hidden" name="user_id" value="<?= $user["id"] ?>">
                <input type="hidden" name="action" value="vip">
                <button type="submit" class="payment-button">Passer en VIP</button>
              </form>

              <!-- Formulaire pour bannir -->
              <form action="traitement/admin_action.php" method="post" style="display:inline;">
                <input type="hidden" name="user_id" value="<?= $user["id"] ?>">
                <input type="hidden" name="action" value="ban">
                <button type="submit" class="payment-button">Bannir</button>
              </form>
            </div>
          </li>
        </ul>
      <?php endforeach; ?>

    </div>
  </main>

  <footer>
    <p>© 2025 High WAY. Tous droits réservés.  
    📍 Paris, France | 📞 +33 1 23 45 67 89 | 📧 contact@HighWAY.fr  
    | Conçu avec 💖 pour pailleter vos vols.✈️</p>
  </footer>

</body>
</html>
