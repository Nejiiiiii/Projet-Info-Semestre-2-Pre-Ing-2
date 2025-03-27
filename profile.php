<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: connexion.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil - Mon Agence de Voyages</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['prenom'] . " " . $_SESSION['nom']); ?></h1>
    <p>Login : <?php echo htmlspecialchars($_SESSION['login']); ?></p>
    <p>Rôle : <?php echo htmlspecialchars($_SESSION['role']); ?></p>
    
    <nav>
        <ul>
            <li><a href="profil.php">Mon Profil</a></li>
            <?php
            // Afficher le lien administrateur si l'utilisateur est administrateur
            if (isset($_SESSION['role']) && $_SESSION['role'] === 'administrateur') {
                echo '<li><a href="admin.php">Administration</a></li>';
            }
            ?>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </nav>
    <hr>
    <h2>Mes voyages</h2>
    <p>Ici s'affichera la liste des voyages réservés (fonctionnalité à implémenter).</p>
</body>
</html>
