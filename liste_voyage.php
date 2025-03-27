<?php
include 'voyages.php';
$voyages = getVoyages();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Liste des Voyages</title>
</head>
<body>
    <h1>Liste des Voyages</h1>
    <a href="ajouter_voyage.php">Ajouter un voyage</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Description</th>
            <th>Prix</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($voyages as $voyage): ?>
            <tr>
                <td><?php echo htmlspecialchars($voyage[0]); ?></td>
                <td><?php echo htmlspecialchars($voyage[1]); ?></td>
                <td><?php echo htmlspecialchars($voyage[2]); ?></td>
                <td><?php echo htmlspecialchars($voyage[3]); ?> €</td>
                <td>
                    <a href="voyage_details.php?id=<?php echo $voyage[0]; ?>">Voir</a>
                    <a href="modifier_voyage.php?id=<?php echo $voyage[0]; ?>">Modifier</a>
                    <a href="supprimer_voyage.php?id=<?php echo $voyage[0]; ?>" onclick="return confirm('Êtes-vous sûr ?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
