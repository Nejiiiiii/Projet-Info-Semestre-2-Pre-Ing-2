<?php
include 'voyages.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = uniqid(); // Génère un ID unique
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    
    ajouterVoyage($id, $nom, $description, $prix);
    header("Location: liste_voyages.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un Voyage</title>
</head>
<body>
    <h1>Ajouter un Voyage</h1>
    <form method="post">
        <label>Nom :</label>
        <input type="text" name="nom" required><br>
        <label>Description :</label>
        <textarea name="description" required></textarea><br>
        <label>Prix (€) :</label>
        <input type="number" name="prix" required><br>
        <button type="submit">Ajouter</button>
    </form>
    <a href="liste_voyages.php">Retour à la liste</a>
</body>
</html>
