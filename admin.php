<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'administrateur') {
    header("Location: connexion.php");
    exit;
}

$chemin = 'data/utilisateurs.csv';
$utilisateurs = [];

if (($handle = fopen($chemin, "r")) !== false) {
    $header = fgetcsv($handle);
    while (($data = fgetcsv($handle)) !== false) {
        $utilisateurs[] = array_combine($header, $data);
    }
    fclose($handle);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration - Mon Agence de Voyages</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Interface Administrateur</h1>
    <nav>
        <ul>
            <li><a href="profil.php">Mon Profil</a></li>
            <li><a href="admin.php">Administration</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </nav>
    <hr>
    <h2>Liste des Utilisateurs</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Login</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Date d'inscription</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($utilisateurs as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['login']); ?></td>
                    <td><?php echo htmlspecialchars($user['nom']); ?></td>
                    <td><?php echo htmlspecialchars($user['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($user['dateInscription']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td>
                        <button>Modifier</button>
                        <button>Bannir</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
