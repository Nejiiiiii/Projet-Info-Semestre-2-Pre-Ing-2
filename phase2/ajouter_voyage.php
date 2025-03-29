<?php
session_start();

// 🔐 Sécurité admin
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
  header("Location: page5.php?erreur=Accès refusé.");
  exit;
}

include 'voyages.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = uniqid();
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = floatval($_POST['prix']);

    ajouterVoyage($id, $nom, $description, $prix);
    header("Location: liste_voyages.php?success=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ajouter un Voyage</title>
  <link rel="stylesheet" href="css/code.css">
</head>
<body>

  <header>
    <h1>📝 Ajouter un nouveau voyage</h1>
    <button onclick="window.location.href='liste_voyages.php'" class="home-button">↩️ Retour à la liste</button>
  </header>

  <main>
    <div class="flexbox">
      <form method="post">
        <input type="text" name="nom" placeholder="Nom du voyage" required><br>
        <textarea name="description" placeholder="Description" rows="4" required></textarea><br>
        <input type="number" name="prix" placeholder="Prix (€)" required><br>

        <div class="button-container">
          <button type="submit" class="payment-button">➕ Ajouter</button>
        </div>
      </form>
    </div>
  </main>

  <footer>
    <p>© 2025 High WAY. Tous droits réservés.  
    📍 Paris, France | 📧 contact@HighWAY.fr</p>
  </footer>

</body>
</html>
