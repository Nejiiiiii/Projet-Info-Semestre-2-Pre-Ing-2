<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bonvoyage/Highway</title>
    <link rel="stylesheet" href="FreeTour.css">
</head>
<body>

<nav>
    <ul>
      <li><a href="page2.php">Présentation du site</a></li>
      <li><a href="page3.php">Recherche de voyage</a></li>
      <li><a href="page4.php">Inscription</a></li>
      <li><a href="page5.php">Connexion</a></li>
      <li><a href="page6.php">Profil</a></li>
      <li><a href="page7.php">Administration</a></li>
    </ul>
</nav>

<header>
    <h1>High WAY!</h1>
</header>

<?php if (isset($_SESSION['login'])): ?>
    <div style="text-align:center; margin-top:10px; font-weight:bold;">
        👋 Bienvenue, <?php echo htmlspecialchars($_SESSION['login']); ?> !
    </div>
<?php endif; ?>

<main>
    <br>
    <div class="box">
        <h2>Découvrez les avantages à avoir choisi ✈️ High WAY ✈️</h2>
    </div>

    <div class="flexbox">
        <h2>🎉 Entrez dans le monde en-dessus High WAY!! 🎉</h2>
        <ul>
            <li>
                <strong>🔒 Site sécurisé</strong>
                <p>Nous utilisons les dernières technologies pour assurer la sécurité de vos données.</p>
            </li>
            <li>
                <strong>📱 Application mobile</strong>
                <p>Restez connecté où que vous soyez avec notre application mobile conviviale.</p>
            </li>
            <li>
                <strong>🔎 Filtres de recherche avancés</strong>
                <p>Trouvez votre siège préféré et des heures qui vous conviennent avec nos filtres de recherche avancés.</p>
            </li>
            <li>
                <strong>Simplicité 👌</strong>
                <p>Restez tranquille pendant votre voyage avec notre équipe bienveillante.</p>
            </li>
        </ul>
    </div>

    <div class="flexbox">
        <h2>Les Billets 💲</h2>
        <ul>
            <li>
                <strong>MiniWay à partir de 199€</strong>
                <p>🔍 Classe Economy<br>📍 Siège au milieu de l'avion<br>🤌🏼 Plats à 0.50€</p>
            </li>
            <li>
                <strong>BigWay à partir de 299€</strong>
                <p>🟢 Classe Business<br>💺 Siège avant<br>🫶 Plats gratuits</p>
            </li>
            <li>
                <strong>UltimateWay à partir de 399€</strong>
                <p>🥇 Classe Premium<br>⚜️ Sièges à l’avant<br>🍔 Buffet à volonté</p>
            </li>
        </ul>
        <div class="button-container">
            <a href="abonnement.php" class="payment-button">Je passe à l'action 💲</a>
        </div>
    </div>

    <div class="flexbox">
        <h2>📣 Nos clients vous parlent</h2>
        <div class="reviews">
            <div class="review-item">
                <img src="sylvie28ans.jpeg" alt="Image de Sylvie" class="review-image">
                <div>
                    <strong>👸 Sylvie, 28 ans :</strong>
                    <p>💖 C'était super! 💖</p>
                </div>
            </div>
            <div class="review-item">
                <img src="antoine65ans.jpeg" alt="Image d'Antoine" class="review-image">
                <div>
                    <strong>🧓 Antoine, 65 ans :</strong>
                    <p>🤝 J'ai pu faire un beau vol 🤝</p>
                </div>
            </div>
            <div class="review-item">
                <img src="fleure.jpeg" alt="Image de Mouloud" class="review-image">
                <div>
                    <strong>👦 Mouloud, 25 ans :</strong>
                    <p>🚀 Best site for ever 🚀</p>
                </div>
            </div>
        </div>
    </div>
</main>

<footer>
    © 2025 High WAY. Tous droits réservés.
    <br>
    📍 Paris, France | 📞 +33 1 23 45 67 89 | 📧 contact@HighWAY.fr
    <br>
    | Conçu avec 💖 pour pailleter vos vols.✈️
</footer>

</body>
</html>

