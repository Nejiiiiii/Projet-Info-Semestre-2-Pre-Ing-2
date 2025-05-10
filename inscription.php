<?php
session_start();
$chemin = 'data/utilisateurs.csv';

// Traitement du formulaire d'inscription
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération et nettoyage des données
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    // Pour la phase 2, tous les nouveaux inscrits seront de rôle "normal"
    $role = 'normal';
    // Hachage du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    // Date d'inscription (au format ISO 8601)
    $dateInscription = date('c');
    
    // Créer le tableau représentant l'utilisateur
    $nouvelUtilisateur = [
        $login,
        $hashedPassword,
        $role,
        $nom,
        $prenom,
        $dateInscription
    ];
    
    // Si le fichier n'existe pas, le créer et y écrire l'en-tête
    if (!file_exists($chemin)) {
        if (!file_exists('data')) {
            mkdir('data', 0777, true);
        }
        $handle = fopen($chemin, 'w');
        $header = ['login', 'motDePasse', 'role', 'nom', 'prenom', 'dateInscription'];
        fputcsv($handle, $header);
        fclose($handle);
    }
    
    // Ajouter l'utilisateur dans le fichier CSV
    $handle = fopen($chemin, 'a');
    if (fputcsv($handle, $nouvelUtilisateur)) {
        $_SESSION['message'] = "Inscription réussie, vous pouvez vous connecter.";
        header("Location: connexion.php");
        exit;
    } else {
        $error = "Erreur lors de l'enregistrement de l'utilisateur.";
    }
    fclose($handle);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Mon Agence de Voyages</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Inscription</h1>
    <?php if(isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form action="" method="post">
        <label for="login">Login :</label><br>
        <input type="text" id="login" name="login" required><br><br>
        
        <label for="password">Mot de passe :</label><br>
        <input type="password" id="password" name="password" required><br><br>
        
        <label for="nom">Nom :</label><br>
        <input type="text" id="nom" name="nom" required><br><br>
        
        <label for="prenom">Prénom :</label><br>
        <input type="text" id="prenom" name="prenom" required><br><br>
        
        <button type="submit">S'inscrire</button>
    </form>
    <p>Déjà inscrit ? <a href="connexion.php">Connectez-vous ici</a>.</p>
    <script src="/public/js/form-validation.js"></script>

</body>
</html>

