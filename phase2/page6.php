<?php
session_start();

// Sécurité : rediriger si l'utilisateur n'est pas connecté
if (!isset($_SESSION["user"])) {
  header("Location: page5.php?erreur=Veuillez vous connecter d'abord.");
  exit;
}

$user = $_SESSION["user"];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Profil - High WAY</title>
  <link rel="stylesheet" href="css/code.css">
</head>
<body>

  <header>
    <h1>Mon Profil</h1>
    <button onclick="window.location.href='page1.php'" class="home-button">Retour à l'accueil ↩️</button>
  </header>

  <main>
    <div class="flexbox">
      <h2>Informations Personnelles</h2>
      <ul>
        <li><strong>Nom d'utilisateur :</strong> <?= htmlspecialchars($user['login']) ?></li>
        <li><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></li>
        <li><strong>Rôle :</strong> <?= htmlspecialchars($user['role']) ?></li>
      </ul>
      <div class="button-container" style="margin-top: 20px;">
        <a href="traitement/logout.php" class="payment-button">Se déconnecter 🚪</a>
      </div>
    </div>
  </main>

  <footer>
    <p>© 2025 High WAY. Tous droits réservés.  
    📍 Paris, France | 📞 +33 1 23 45 67 89 | 📧 contact@HighWAY.fr  
    | Conçu avec 💖 pour pailleter vos vols.✈️</p>
  </footer>

</body>
</html>
