<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
  header("Location: page5.php?erreur=Accès interdit.");
  exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ajouter un voyage</title>
  <link rel="stylesheet" href="css/code.css">
</head>
<body>

  <header>
    <h1>📝 Ajouter un nouveau voyage</h1>
    <button onclick="window.location.href='page7.php'" class="home-button">Retour admin ↩️</button>
  </header>

  <main>
    <div class="flexbox">
      <form action="traitement/ajouter_voyage.php" method="post">
        <input type="text" name="titre" placeholder="Titre" required><br>
        <input type="text" name="destination" placeholder="Destination" required><br>
        <input type="date" name="date_depart" required><br>
        <input type="date" name="date_retour" required><br>
        <input type="number" name="prix" placeholder="Prix (€)" required><br>
        <textarea name="description" placeholder="Description" rows="4" required></textarea><br>
        <input type="text" name="options" placeholder="Options séparées par des virgules"><br>
        <input type="text" name="image" placeholder="Nom de l'image (ex: tokyo.jpg)"><br>

        <div class="button-container">
          <button type="submit" class="payment-button">➕ Ajouter le voyage</button>
        </div>
      </form>
    </div>
  </main>

  <footer>
    <p>© 2025 High WAY. Tous droits réservés.</p>
  </footer>

</body>
</html>
