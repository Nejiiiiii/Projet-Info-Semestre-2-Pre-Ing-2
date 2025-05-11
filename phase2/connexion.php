<?php
session_start();
$chemin = __DIR__ . '/data/utilisateurs.csv';

// Si l'utilisateur est déjà connecté, rediriger vers le profil
if (isset($_SESSION['login'])) {
    header("Location: profil.php");
    exit;
}

$errors = [];

// Si message de succès (inscription), on le récupère
if (!empty($_SESSION['message'])) {
    $success = $_SESSION['message'];
    unset($_SESSION['message']);
}

// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login    = trim($_POST['login']    ?? '');
    $password = trim($_POST['password'] ?? '');

    // --- Validation serveur ---
    if ($login === '') {
        $errors[] = 'Le login est requis.';
    }
    if ($password === '') {
        $errors[] = 'Le mot de passe est requis.';
    }

    // Si pas d'erreurs, on cherche dans le CSV
    if (empty($errors)) {
        $found = false;
        if (($h = fopen($chemin, 'r')) !== false) {
            $header = fgetcsv($h);
            while (($row = fgetcsv($h)) !== false) {
                $util = array_combine($header, $row);
                if ($util['login'] === $login
                    && password_verify($password, $util['motDePasse'])
                ) {
                    // authentification réussie
                    $_SESSION['login']  = $util['login'];
                    $_SESSION['role']   = $util['role'];
                    $_SESSION['nom']    = $util['nom'];
                    $_SESSION['prenom'] = $util['prenom'];
                    $found = true;
                    break;
                }
            }
            fclose($h);
            if ($found) {
                header("Location: profil.php");
                exit;
            } else {
                $errors[] = 'Identifiants incorrects.';
            }
        } else {
            $errors[] = 'Impossible d’accéder aux données utilisateurs.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion – Mon Agence de Voyages</title>
  <link rel="stylesheet" href="css/style.css">
  <link id="theme-stylesheet" rel="stylesheet" href="/css/light.css">
</head>
<body>
  <h1>Connexion</h1>

  <!-- Affichage message succès inscription -->
  <?php if (!empty($success)): ?>
    <p style="color:green;"><?= htmlspecialchars($success) ?></p>
  <?php endif; ?>

  <!-- Affichage erreurs serveur -->
  <?php if (!empty($errors)): ?>
    <ul class="error-list" style="color:red;">
      <?php foreach ($errors as $err): ?>
        <li><?= htmlspecialchars($err) ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <form action="" method="post" class="needs-validation">
    <div class="form-group">
      <label for="login">Login :</label><br>
      <input
        type="text"
        id="login"
        name="login"
        required
        data-minlength="3"
        maxlength="30"
        value="<?= htmlspecialchars($_POST['login'] ?? '') ?>"
      /><br><br>
    </div>

    <div class="form-group">
      <label for="password">Mot de passe :</label><br>
      <input
        type="password"
        id="password"
        name="password"
        required
        data-minlength="6"
      /><br><br>
    </div>

    <button type="submit">Se connecter</button>
  </form>

  <p>Pas encore inscrit ? <a href="inscription.php">Inscrivez-vous ici</a>.</p>

  <!-- Chargement du script de validation client -->
  <script src="/public/js/form-validation.js"></script>
  <script src="/js/themeSwitcher.min.js"></script>
</body>
</html>
