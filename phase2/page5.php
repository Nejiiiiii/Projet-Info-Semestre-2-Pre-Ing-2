<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>High WAY / Connexion</title>
  <link rel="stylesheet" href="css/code.css">
</head>
<body>

  <header style="text-align: center; margin-top: 20px; color: white; font-size: 32px; font-weight: bold;">
    High WAY!
  </header>

  <!-- Bouton retour -->
  <button onclick="window.location.href='page1.php'" class="home-button">Retour à l'accueil ↩️</button>

  <!-- Formulaire de connexion -->
  <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 100vh; padding-bottom: 60px;">
    <div class="login-container" style="width: 360px; background: rgba(0, 0, 0, 0.5); padding: 20px; border-radius: 15px; box-shadow: 0 0 10px rgba(0,0,0,0.5);">

      <h2 style="margin-top: 0; text-align: center;">Bienvenue à nouveau !</h2>
      <h3 style="text-align: center; margin-bottom: 15px;">Connexion</h3>

      <form action="traitement/connexion.php" method="post">
        <input type="email" name="email" placeholder="Email" required
               style="width:100%; margin-bottom:10px; padding:8px; border: 1px solid #fff; border-radius: 5px; background: rgba(255,255,255,0.2); color: #fff;">

        <input type="password" name="psw" placeholder="Mot de passe" required
               style="width:100%; margin-bottom:15px; padding:8px; border: 1px solid #fff; border-radius: 5px; background: rgba(255,255,255,0.2); color: #fff;">

        <button type="submit"
                style="width:100%; padding:12px; font-size:18px; background: linear-gradient(to right, #1D2671, #C33764); border: none; color: white; border-radius: 5px; box-shadow: 0px 4px 6px rgba(0,0,0,0.3); transition: transform 0.3s, background 0.3s;">
          Me connecter
        </button>

        <p class="message" style="text-align: center; margin-top: 10px;">
          Pas encore inscrit ? <a href="page4.php" style="color:#fff; text-decoration:underline;">S'inscrire</a>
        </p>
      </form>

      <!-- Afficher message d'erreur si mauvais identifiants -->
      <?php if (isset($_GET['erreur'])): ?>
        <p style="color:red; text-align:center; margin-top: 10px;">
          <?= htmlspecialchars($_GET['erreur']) ?>
        </p>
      <?php endif; ?>

    </div>
  </div>

  <footer>
    © 2025 High WAY. Tous droits réservés. <br>
    📍 Paris, France | 📞 +33 1 23 45 67 89 | 📧 contact@HighWAY.fr  
    | Conçu avec 💖 pour pailleter vos vols.✈️
  </footer>

</body>
</html>
