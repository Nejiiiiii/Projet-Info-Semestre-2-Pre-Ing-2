<?php
session_start();

// Vérification que l'utilisateur est connecté et admin
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: page5.php?erreur=acces_refuse");
    exit;
}

// Charger les utilisateurs depuis le fichier JSON
$utilisateurs = [];
$fichier = "utilisateurs.json";

if (file_exists($fichier)) {
    $utilisateurs = json_decode(file_get_contents($fichier), true);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Administration - Liste des Utilisateurs</title>
  <link rel="stylesheet" href="FreeTour.css">
</head>
<body>
  <header>
    <h1>Administration</h1>
    <button onclick="window.location.href='page1.php'" class="home-button">Retour à l'accueil ↩️</button>
  </header>

  <main>
    <div class="flexbox">
      <h2>Liste des Utilisateurs</h2>

      <?php if (empty($utilisateurs)): ?>
        <p>Aucun utilisateur enregistré.</p>
      <?php else: ?>
        <?php foreach ($utilisateurs as $user): ?>
          <ul>
            <li><strong><?= htmlspecialchars($user['pseudo']) ?></strong></li>
            <li>Login : <?= htmlspecialchars($user['login']) ?></li>
            <li>Rôle : <?= htmlspecialchars($user['role']) ?></li>
            <li>Date inscription : <?= htmlspecialchars($user['date_inscription']) ?></li>
            <li>
              <div class="button-container">
                <form action="admin_action.php" method="post" style="display:inline;">
                  <input type="hidden" name="login" value="<?= htmlspecialchars($user['login']) ?>">
                  <input type="submit" name="action" value="Passer en VIP" class="payment-button">
                  <input type="submit" name="action" value="Bannir" class="payment-button">
                </form>
              </div>
            </li>
          </ul>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </main>

  <footer>
    <p>© 2025 High WAY. Tous droits réservés.
    📍 Paris, France | 📞 +33 1 23 45 67 89 | 📧 contact@HighWAY.fr |
    Conçu avec 💖 pour pailleter vos vols.✈️</p>
  </footer>
</body>
</html>
