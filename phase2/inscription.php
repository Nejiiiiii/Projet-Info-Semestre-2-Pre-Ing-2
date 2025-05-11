<?php
session_start();
$chemin = __DIR__ . '/data/utilisateurs.csv';
$errors = [];

// Traitement du formulaire d'inscription
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login    = trim($_POST['login']   ?? '');
    $password = trim($_POST['password']?? '');
    $nom      = trim($_POST['nom']     ?? '');
    $prenom   = trim($_POST['prenom']  ?? '');
    $role     = 'normal';
    $dateInscription = date('c');

    if ($login === '') $errors[] = 'Le login est requis.';
    elseif (strlen($login) < 3) $errors[] = 'Le login doit faire au moins 3 caractères.';
    if ($password === '') $errors[] = 'Le mot de passe est requis.';
    elseif (strlen($password) < 6) $errors[] = 'Le mot de passe doit contenir au moins 6 caractères.';
    if ($nom === '') $errors[] = 'Le nom est requis.';
    if ($prenom === '') $errors[] = 'Le prénom est requis.';

    if (empty($errors) && file_exists($chemin)) {
        $h = fopen($chemin, 'r');
        fgetcsv($h);
        while (($row = fgetcsv($h)) !== false) {
            if ($row[0] === $login) { 
                $errors[] = 'Ce login est déjà utilisé.'; 
                break; 
            }
        }
        fclose($h);
    }

    if (empty($errors)) {
        $hPwd = password_hash($password, PASSWORD_DEFAULT);
        $user = [$login, $hPwd, $role, $nom, $prenom, $dateInscription];
        if (!file_exists($chemin)) {
            mkdir(dirname($chemin), 0777, true);
            $h = fopen($chemin, 'w');
            fputcsv($h, ['login','motDePasse','role','nom','prenom','dateInscription']);
            fclose($h);
        }
        $h = fopen($chemin, 'a');
        fputcsv($h, $user);
        fclose($h);
        $_SESSION['message'] = "Inscription réussie ; vous pouvez vous connecter.";
        header("Location: connexion.php");
        exit;
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

    <label for="psw">Mot de passe :</label><br>
    <input
      type="password"
      id="psw"
      name="password"
      required
      data-minlength="6"
      data-maxlength="50"
      oninput="checkPasswordStrength()"
    ><br>
    <div id="strength-bar" style="width:0;height:10px;border-radius:10px;background:transparent;"></div>
    <br>

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

  <script src="/public/js/form-validation.js"></script>
  <script src="/public/js/checkPasswordStrength.js"></script>
</body>
</html>

