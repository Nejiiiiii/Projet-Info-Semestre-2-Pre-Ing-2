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

$etapes = getEtapesByVoyageId($id);
$options = getOptionsByVoyageId($id);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Détails du Voyage</title>
</head>
<body>
    <h1><?php echo htmlspecialchars($voyage[1]); ?></h1>
    <p><strong>Description :</strong> <?php echo htmlspecialchars($voyage[2]); ?></p>
    <p><strong>Prix :</strong> <?php echo htmlspecialchars($voyage[3]); ?> €</p>
    
    <h2>Étapes</h2>
    <ul>
        <?php foreach ($etapes as $etape): ?>
            <li><?php echo htmlspecialchars($etape[2]); ?></li>
        <?php endforeach; ?>
    </ul>
    
    <h2>Options</h2>
    <ul>
        <?php foreach ($options as $option): ?>
            <li><?php echo htmlspecialchars($option[2]); ?></li>
        <?php endforeach; ?>
    </ul>
    
    <a href="liste_voyages.php">Retour à la liste</a>
</body>
</html>
