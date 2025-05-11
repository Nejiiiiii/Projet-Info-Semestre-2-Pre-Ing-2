<?php
session_start();
$chemin = __DIR__ . '/data/utilisateurs.csv';
$errors = [];

// Traitement du formulaire d'inscription
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération et nettoyage
    $login   = trim($_POST['login']   ?? '');
    $password= trim($_POST['password']?? '');
    $nom     = trim($_POST['nom']     ?? '');
    $prenom  = trim($_POST['prenom']  ?? '');
    $role    = 'normal';
    $dateInscription = date('c');

    // --- Validation serveur ---
    if ($login === '') {
        $errors[] = 'Le login est requis.';
    } elseif (strlen($login) < 3) {
        $errors[] = 'Le login doit faire au moins 3 caractères.';
    }
    if ($password === '') {
        $errors[] = 'Le mot de passe est requis.';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Le mot de passe doit contenir au moins 6 caractères.';
    }
    if ($nom === '') {
        $errors[] = 'Le nom est requis.';
    }
    if ($prenom === '') {
        $errors[] = 'Le prénom est requis.';
    }

    // Vérifier doublon de login dans le CSV
    if (empty($errors) && file_exists($chemin)) {
        if (($handle = fopen($chemin, 'r')) !== false) {
            // sauter l'en-tête
            fgetcsv($handle);
            while (($row = fgetcsv($handle)) !== false) {
                if (isset($row[0]) && $row[0] === $login) {
                    $errors[] = 'Ce login est déjà utilisé.';
                    break;
                }
            }
            fclose($handle);
        }
    }

    // Si pas d'erreurs, on ajoute
    if (empty($errors)) {
        // Hachage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $nouvelUtilisateur = [
            $login,
            $hashedPassword,
            $role,
            $nom,
            $prenom,
            $dateInscription
        ];

        // Création du fichier si nécessaire
        if (!file_exists($chemin)) {
            if (!is_dir(dirname($chemin))) {
                mkdir(dirname($chemin), 0777, true);
            }
            $h = fopen($chemin, 'w');
            fputcsv($h, ['login','motDePasse','role','nom','prenom','dateInscription']);
            fclose($h);
        }
        // Ajout de l'utilisateur
        if (($h = fopen($chemin, 'a')) !== false) {
            fputcsv($h, $nouvelUtilisateur);
            fclose($h);
            $_SESSION['message'] = "Inscription réussie ; vous pouvez vous connecter.";
            header("Location: connexion.php");
            exit;
        } else {
            $errors[] = "Impossible d'enregistrer l'utilisateur.";
        }
    }
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

  <!-- Affichage des erreurs serveur -->
  <?php if (!empty($errors)): ?>
    <ul class="error-list" style="color:red;">
      <?php foreach ($errors as $err): ?>
        <li><?= htmlspecialchars($err) ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <form action="" method="post" class="needs-validation">
    <label for="login">Login :</label><br>
    <input
      type="text"
      id="login"
      name="login"
      required
      data-minlength="3"
      maxlength="30"
      value="<?= htmlspecialchars($_POST['login'] ?? '') ?>"
    ><br><br>

    <label for="password">Mot de passe :</label><br>
    <input
      type="password"
      id="password"
      name="password"
      required
      data-minlength="6"
      data-maxlength="50"
    ><br><br>

    <label for="nom">Nom :</label><br>
    <input
      type="text"
      id="nom"
      name="nom"
      required
      data-minlength="2"
      maxlength="50"
      value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>"
    ><br><br>

    <label for="prenom">Prénom :</label><br>
    <input
      type="text"
      id="prenom"
      name="prenom"
      required
      data-minlength="2"
      maxlength="50"
      value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>"
    ><br><br>

    <button type="submit">S'inscrire</button>
  </form>

  <p>Déjà inscrit ? <a href="connexion.php">Connectez-vous ici</a>.</p>

  <!-- Validation client -->
  <script src="/public/js/form-validation.js"></script>
</body>
</html>
