<?php
// Connexion à la base de données
include('connexion.php'); // Assure-toi que la connexion à la DB est correcte

// Récupérer l'ID du voyage depuis l'URL
if (isset($_GET['id'])) {
    $voyage_id = $_GET['id'];
} else {
    die('Aucun voyage spécifié.');
}

// Récupérer les informations du voyage
$query = "SELECT * FROM voyages WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$voyage_id]);
$voyage = $stmt->fetch();

if (!$voyage) {
    die('Voyage introuvable.');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du voyage</title>
    <link rel="stylesheet" href="style.css"> <!-- Assure-toi que tu as un fichier CSS -->
</head>
<body>
    <h1>Détails du voyage</h1>
    <h2><?php echo $voyage['titre']; ?></h2>
    <p><strong>Date de début :</strong> <?php echo $voyage['date_debut']; ?></p>
    <p><strong>Date de fin :</strong> <?php echo $voyage['date_fin']; ?></p>
    <p><strong>Prix :</strong> <?php echo number_format($voyage['prix'], 2, ',', ' '); ?> €</p>
    <p><strong>Description :</strong> <?php echo nl2br($voyage['description']); ?></p>

    <a href="profil.php">Retour à votre profil</a>
</body>
</html>
