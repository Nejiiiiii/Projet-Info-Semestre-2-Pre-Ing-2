<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>High WAY / Inscription</title>
  <link rel="stylesheet" href="css/code.css">
  <script src="js/inscription.js" defer></script> <!-- Optionnel si tu as un script -->
</head>
<body>

  <header style="text-align: center; margin-top: 20px; color: white; font-size: 32px; font-weight: bold;">
    High WAY!
  </header>

  <button onclick="window.location.href='page1.php'" class="home-button">Retour à l'accueil ↩️</button>

  <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 100vh; padding-bottom: 60px;">
    <div class="login-container" style="width: 360px; background: rgba(0, 0, 0, 0.5); padding: 20px; border-radius: 15px; box-shadow: 0 0 10px rgba(0,0,0,0.5);">
      
      <h2 style="text-align: center;">Ce n'est que le début...</h2>
      <h3 style="text-align: center; margin-bottom: 15px;">Mon inscription</h3>

      <form action="traitement/inscription.php" method="post">
        <input type="text" name="uname" placeholder="Nom d'utilisateur" required
               style="width:100%; margin-bottom:10px; padding:8px; border: 1px solid #fff; border-radius: 5px; background: rgba(255,255,255,0.2); color: #fff;">
        
        <input type="email" name="email" placeholder="Email" required
               style="width:100%; margin-bottom:10px; padding:8px; border: 1px solid #fff; border-radius: 5px; background: rgba(255,255,255,0.2); color: #fff;">

        <input type="password" id="psw" name="psw" placeholder="Mot de passe" required onkeyup="checkPasswordStrength();"
               style="width:100%; margin-bottom:10px; padding:8px; border: 1px solid #fff; border-radius: 5px; background: rgba(255,255,255,0.2); color: #fff;">
        
        <div id="strength-bar" style="width:100%; margin-bottom:10px;"></div>

        <input type="password" name="confirm_psw" placeholder="Confirmer le mot de passe" required
               style="width:100%; margin-bottom:15px; padding:8px; border: 1px solid #fff; border-radius: 5px; background: rgba(255,255,255,0.2); color: #fff;">

        <button type="submit"
                style="width:100%; padding:12px; font-size:18px; background: linear-gradient(to right, #1D2671, #C33764); border: none; color: white; border-radius: 5px; box-shadow: 0px 4px 6px rgba(0,0,0,0.3); transition: transform 0.3s, background 0.3s;">
          Je m'inscris 😍
        </button>

        <p class="message" style="text-align: center; margin-top: 10px;">
          Déjà enregistré ? <a href="page5.php" style="color:#fff; text-decoration:underline;">Se connecter</a>
        </p>
      </form>

    </div>
  </div>

  <footer>
    © 2025 High WAY. Tous droits réservés. <br>
    📍 Paris, France | 📞 +33 1 23 45 67 89 | 📧 contact@HighWAY.fr  
    | Conçu avec 💖 pour pailleter vos vols.✈️
  </footer>

</body>
</html>
