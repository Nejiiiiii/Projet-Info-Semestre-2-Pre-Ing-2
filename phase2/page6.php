<?php
session_start();

// 🔐 Redirection si non connecté
if (!isset($_SESSION["user"])) {
  header("Location: page5.php?erreur=Veuillez vous connecter d'abord.");
  exit;
}

$user = $_SESSION["user"];

// 📂 Charger les réservations
$resFile = "data/reservations.json";
$reservations = file_exists($resFile) ? json_decode(file_get_contents($resFile), true) : [];

// 📂 Charger les voyages
$voyageFile = "data/voyages.json";
$voyages = file_exists($voyageFile) ? json_decode(file_get_contents($voyageFile), true) : [];

// 🎯 Filtrer les réservations de l'utilisateur
$userId = $user["id"];
$mesReservations = array_filter($reservations, fn($r) => $r["user_id"] == $userId);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <script src="js/profil.js" defer></script>
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
      <h2>👤 Informations Personnelles</h2>
 <ul>
  <li>
    <strong>Nom d'utilisateur :</strong>
    <span id="user-login"><?= htmlspecialchars($user['login']) ?></span>
    <button onclick="editField('login')">✏️</button>
  </li>

  <li>
    <strong>Email :</strong>
    <span id="user-email"><?= htmlspecialchars($user['email']) ?></span>
    <button onclick="editField('email')">✏️</button>
  </li>

  <li>
    <strong>Rôle :</strong>
    <span id="user-role"><?= htmlspecialchars($user['role']) ?></span>
    <!-- pas modifiable, donc pas de bouton -->
  </li>
</ul>

      <div class="button-container" style="margin-top: 20px;">
        <a href="traitement/logout.php" class="payment-button">Se déconnecter 🚪</a>
      </div>
    </div>

    <div class="flexbox">
      <h2>📋 Mes Réservations</h2>
      <?php if (empty($mesReservations)): ?>
        <p>Aucune réservation pour le moment.</p>
      <?php else: ?>
        <ul>
          <?php foreach ($mesReservations as $res): 
            $voyage = current(array_filter($voyages, fn($v) => $v["id"] == $res["voyage_id"]));
          ?>
            <li>
              <strong><?= htmlspecialchars($voyage["titre"] ?? "Voyage inconnu") ?></strong><br>
              Réservé le : <?= date("d/m/Y à H:i", strtotime($res["date"])) ?>
              <br>
              <a href="voyage_detaille.php?id=<?= $voyage["id"] ?>" class="payment-button">Voir ce voyage</a>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
  </main>

  <footer>
    <p>© 2025 High WAY. Tous droits réservés.  
    📍 Paris, France | 📞 +33 1 23 45 67 89 | 📧 contact@HighWAY.fr  
    | Conçu avec 💖 pour pailleter vos vols.✈️</p>
  </footer>

</body>
</html>

