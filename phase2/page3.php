<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr" style="margin:0; padding:0;">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recherche de Voyages</title>
  <link rel="stylesheet" href="FreeTour.css">
</head>
<body style="min-height:100vh; margin:0; padding:0;">
  <header>
    <h1>Recherche de Voyages</h1>
    <button onclick="window.location.href='page1.php'" class="home-button">Retour à l'accueil ↩️</button>
  </header>

  <?php if (isset($_SESSION['login'])): ?>
    <div style="text-align:center; font-weight:bold; margin-top:10px;">
      👋 Bonjour, <?php echo htmlspecialchars($_SESSION['login']); ?> !
    </div>
  <?php endif; ?>

  <main>
    <div class="box">
      <h2>Trouvez votre prochaine aventure</h2>
      <form action="resultats.php" method="GET" class="flexbox">
        <label for="destination">Destination :</label>
        <input type="text" id="destination" name="destination" placeholder="Entrez une destination...">

        <label for="dates">Dates :</label>
        <input type="date" id="date-depart" name="date-depart">
        <input type="date" id="date-retour" name="date-retour">

        <label for="options">Options :</label>
        <select id="options" name="options">
          <option value="all">Toutes</option>
          <option value="hebergement">Hébergement</option>
          <option value="restauration">Restauration</option>
          <option value="activites">Activités</option>
          <option value="transport">Transport</option>
        </select>

        <div class="button-container">
          <button type="submit" class="payment-button">Rechercher</button>
        </div>
      </form>
    </div>
  </main>

  <footer>
    <p>© 2025 High WAY. Tous droits réservés. 📍 Paris, France | 📞 +33 1 23 45 67 89 | 📧 contact@HighWAY.fr |
    Conçu avec 💖 pour pailleter vos vols.✈️</p>
  </footer>
</body>
</html>
