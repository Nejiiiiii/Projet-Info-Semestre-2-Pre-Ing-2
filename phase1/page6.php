<?php
session_start();

// Redirection si non connecté
if (!isset($_SESSION['login'])) {
    header("Location: page5.php?erreur=connexion_requise");
    exit;
}

// Chargement des données utilisateur
$utilisateur = null;
$login = $_SESSION['login'];
$fichier = "utilisateurs.json";

if (file_exists($fichier)) {
    $utilisateurs = json_decode(file_get_contents($fichier), true);
    foreach ($utilisateurs as $u) {
        if ($u['login'] === $login) {
            $utilisateur = $u;
            break;
        }
    }
}

// Redirection de sécurité si l'utilisateur n'existe pas
if (!$utilisateur) {
    session_destroy();
    header("Location: page5.php?erreur=utilisateur_introuvable");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Utilisateur</title>
  <link rel="stylesheet" href="FreeTour.css">
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
        <li><strong>Nom :</strong> <span id="user-name"><?= htmlspecialchars($utilisateur['nom']) ?></span></li>
        <li><strong>Pseudo :</strong> <span><?= htmlspecialchars($utilisateur['pseudo']) ?></span></li>
        <li><strong>Date de naissance :</strong> <span><?= htmlspecialchars($utilisateur['naissance']) ?></span></li>
        <li><strong>Adresse :</strong> <span id="user-address"><?= htmlspecialchars($utilisateur['adresse']) ?></span></li>
        <li><strong>Login :</strong> <span><?= htmlspecialchars($utilisateur['login']) ?></span></li>
        <li><strong>Date d’inscription :</strong> <span><?= htmlspecialchars($utilisateur['date_inscription']) ?></span></li>
      </ul>
    </div>
  </main>

  <footer>
    <p>© 2025 High WAY. Tous droits réservés. 📍 Paris, France | 📞 +33 1 23 45 67 89 | 📧 contact@HighWAY.fr |
    Conçu avec 💖 pour pailleter vos vols.✈️</p>
  </footer>
</body>
</html>
