<?php
session_start();
$chemin = 'data/utilisateurs.csv';

// Si l'utilisateur est déjà connecté, rediriger vers le profil
if (isset($_SESSION['login'])) {
    header("Location: profil.php");
    exit;
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);
    $found = false;

    if (($handle = fopen($chemin, "r")) !== false) {
        // Récupérer l'en-tête
        $header = fgetcsv($handle);
        while (($data = fgetcsv($handle)) !== false) {
            $utilisateur = array_combine($header, $data);
            if ($utilisateur['login'] == $login) {
                // Vérifier le mot de passe
                if (password_verify($password, $utilisateur['motDePasse'])) {
                    // Démarrer la session utilisateur
                    $_SESSION['login'] = $utilisateur['login'];
                    $_SESSION['role'] = $utilisateur['role'];
                    $_SESSION['nom'] = $utilisateur['nom'];
                    $_SESSION['prenom'] = $utilisateur['prenom'];
                    $found = true;
                    break;
                }
            }
        }
        fclose($handle);
        if ($found) {
            header("Location: profil.php");
            exit;
        } else {
            $error = "Identifiants incorrects.";
        }
    } else {
        $error = "Erreur lors de l'ouverture du fichier de données.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Mon Agence de Voyages</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Connexion</h1>
    <?php
    if (!empty($_SESSION['message'])) {
        echo "<p style='color:green;'>" . $_SESSION['message'] . "</p>";
        unset($_SESSION['message']);
    }
    if ($error != "") {
        echo "<p style='color:red;'>$error</p>";
    }
    ?>
    <form action="" method="post">
        <label for="login">Login :</label><br>
        <input type="text" id="login" name="login" required><br><br>
        
        <label for="password">Mot de passe :</label><br>
        <input type="password" id="password" name="password" required><br><br>
        
        <button type="submit">Se connecter</button>
    </form>
    <p>Pas encore inscrit ? <a href="inscription.php">Inscrivez-vous ici</a>.</p>
</body>
</html>
