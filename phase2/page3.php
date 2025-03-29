<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recherche de Voyages - High WAY</title>
  <link rel="stylesheet" href="css/code.css">
</head>
<body>

  <!-- Bouton accueil -->
  <button onclick="window.location.href='page1.php'" class="home-button">Retour à l'accueil ↩️</button>

  <header>
    <h1>Recherche de Voyages</h1>
  </header>

  <main>
    <div class="box">
      <h2>Trouvez votre prochaine aventure</h2>

      <form action="traitement/resultat.php" method="GET" class="flexbox">
        <!-- Destination -->
        <label for="destination">Destination :</label>
        <input type="text" id="destination" name="destination" placeholder="Entrez une destination..." required>

        <!-- Dates -->
        <label for="dates">Dates :</label>
        <input type="date" id="date-depart" name="date_depart" required>
        <input type="date" id="date-retour" name="date_retour" required>

        <!-- Options -->
        <label for="options">Options :</label>
        <select id="options" name="option">
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
    <p>© 2025 High WAY. Tous droits réservés.  
    📍 Paris, France | 📞 +33 1 23 45 67 89 | 📧 contact@HighWAY.fr  
    | Conçu avec 💖 pour pailleter vos vols.✈️</p>
  </footer>

</body>
</html>

