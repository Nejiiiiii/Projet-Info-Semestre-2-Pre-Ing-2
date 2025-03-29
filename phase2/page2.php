<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Présentation - HIGH Way</title>
  <link rel="stylesheet" href="css/code.css">
</head>
<body>

  <!-- Bouton accueil -->
  <button onclick="window.location.href='page1.php'" class="home-button">Retour à l'accueil ↩️</button>

  <header>
    <h1>Bienvenue sur HIGH Way!</h1>
  </header>

  <main>
    <div class="box">
      <h2>Qui sommes-nous ?</h2>
      <p>
        High-Way est une agence de voyages spécialisée dans les séjours "pseudo-sur-mesure". 
        Nous proposons des circuits préétablis tout en laissant la possibilité de personnaliser 
        certaines options comme l'hébergement, la restauration, les activités et le transport.
      </p>
    </div>

    <div class="box">
      <h2>Rechercher un voyage</h2>
      <form action="resultat.php" method="GET" class="flexbox">
        <label for="recherche">Tapez une destination :</label>
        <input type="text" id="recherche" name="recherche" placeholder="Ex : Paris, Tokyo, New York..." required>
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
