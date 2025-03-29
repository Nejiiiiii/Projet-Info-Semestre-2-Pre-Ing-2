<?php
// Connexion à la base de données
include('connexion.php'); // Assure-toi que la connexion à la DB est correcte

// Récupérer l'ID de l'utilisateur (assumé que l'utilisateur est déjà connecté)
session_start();
$user_id = $_SESSION['user_id'];

// Récupérer la liste des voyages payés par l'utilisateur
$query = "SELECT v.id, v.titre, v.date_debut, v.date_fin, v.prix 
          FROM voyages v
          JOIN transactions t ON v.id = t.voyage_id
          WHERE t.user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$voyages = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil utilisateur</title>
    <link rel="stylesheet" href="style.css"> <!-- Assure-toi que tu as un fichier CSS -->
</head>
<body>
    <h1>Bienvenue sur votre profil</h1>
    <h2>Liste des voyages payés</h2>
    <table>
        <tr>
            <th>Titre du voyage</th>
            <th>Date de début</th>
            <th>Date de fin</th>
            <th>Prix</th>
        </tr>
        <?php foreach ($voyages as $voyage): ?>
        <tr>
            <td><a href="details_voyage.php?id=<?php echo $voyage['id']; ?>"><?php echo $voyage['titre']; ?></a></td>
            <td><?php echo $voyage['date_debut']; ?></td>
            <td><?php echo $voyage['date_fin']; ?></td>
            <td><?php echo number_format($voyage['prix'], 2, ',', ' '); ?> €</td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
