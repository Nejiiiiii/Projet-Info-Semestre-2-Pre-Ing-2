<?php
include 'voyages.php';

if (!isset($_GET['id'])) {
    die("ID du voyage manquant.");
}

$id = $_GET['id'];
$voyage = getVoyageById($id);

if (!$voyage) {
    die("Voyage introuvable.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    
    modifierVoyage($id, $nom, $description, $prix);
    header("Location: liste_voyages.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Modifier un Voyage</title>
</head>
<body>
    <h1>Modifier le Voyage</h1>
    <form method="post">
        <label>Nom :</label>
        <input type="text" name="nom" value="<?php echo htmlspecialchars($voyage[1]); ?>" required><br>
        <label>Description :</label>
        <textarea name="description" required><?php echo htmlspecialchars($voyage[2]); ?></textarea><br>
        <label>Prix (€) :</label>
        <input type="number" name="prix" value="<?php echo htmlspecialchars($voyage[3]); ?>" required><br>
        <button type="submit">Modifier</button>
    </form>
    <a href="liste_voyages.php">Retour à la liste</a>
</body>
</html>
