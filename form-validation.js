
document.addEventListener('DOMContentLoaded', () => {
  const forms = document.querySelectorAll('form.needs-validation');

  forms.forEach(form => {
    const inputs = form.querySelectorAll('input[required], textarea[required]');
    // Compteurs pour maxlength
    form.querySelectorAll('[data-maxlength]').forEach(field => {
      const max = +field.dataset.maxlength;
      const counter = document.createElement('small');
      counter.className = 'char-counter';
      counter.textContent = `0 / ${max}`;
      field.parentNode.append(counter);
      field.addEventListener('input', () => {
        const len = field.value.length;
        counter.textContent = `${len} / ${max}`;
        counter.classList.toggle('text-error', len > max);
      });
    });
    // Toggle mot de passe
    form.querySelectorAll('input[type=password]').forEach(pw => {
      const btn = document.createElement('button');
      btn.type = 'button'; btn.className = 'toggle-pw';
      btn.innerHTML = '<i class="icon-eye"></i>';
      pw.parentNode.append(btn);
      btn.addEventListener('click', () => {
        pw.type = pw.type === 'password' ? 'text' : 'password';
        btn.innerHTML = pw.type === 'password' ? '<i class="icon-eye"></i>' : '<i class="icon-eye-off"></i>';
      });
    });

    form.addEventListener('submit', e => {
      let valid = true;
      inputs.forEach(field => {
        field.classList.remove('invalid');
        let err = '';
        const val = field.value.trim();
        if (!val) err = 'Champ requis.';
        else if (field.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) err = 'Email invalide.';
        else if (field.dataset.minlength && val.length < +field.dataset.minlength)
          err = `Au moins ${field.dataset.minlength} caractères.`;

        let msg = field.nextElementSibling;
        if (!msg || !msg.classList.contains('error-msg')) {
          msg = document.createElement('div');
          msg.className = 'error-msg';
          field.parentNode.insertBefore(msg, field.nextSibling);
        }
        msg.textContent = err;
        if (err) {
          field.classList.add('invalid');
          valid = false;
        }
      });
      if (!valid) e.preventDefault();
    });
  });
});
```

---

## 2. Modifications à apporter à **`register.php`**

```php
<?php
// register.php (à l’intérieur de votre dossier public ou src)
session_start();
require_once __DIR__ . '/../config/database.php'; // config PDO

// Récupérer et nettoyer
$username = trim($_POST['username'] ?? '');
$email    = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
$password = $_POST['password'] ?? '';
$errors   = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!$username)   $errors[] = 'Nom d’utilisateur requis.';
  if (!$email)      $errors[] = 'Email non valide.';
  if (strlen($password) < 6) $errors[] = 'Mot de passe ≥ 6 caractères.';

  if (empty($errors)) {
    // Vérifier doublon
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    if ($stmt->fetch()) {
      $errors[] = 'Email déjà utilisé.';
    } else {
      // Insérer en base
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $ins = $pdo->prepare(
        "INSERT INTO users (username, email, password) VALUES (:u, :e, :p)"
      );
      $ins->execute(['u' => $username, 'e' => $email, 'p' => $hash]);
      $_SESSION['user_id'] = $pdo->lastInsertId();
      header('Location: dashboard.php');
      exit;
    }
  }
}
// Affichage du formulaire plus bas, avec affichage de $errors
?>
```

**Changements clés** :

1. Utiliser `filter_var()` pour valider l’email.
2. Vérifier l’existence avant insertion.
3. Hasher le mot de passe avec `password_hash()`.
4. Gérer les erreurs et les afficher dans le HTML.

---

## 3. Modifications à apporter à **`login.php`**

```php
<?php
session_start();
require_once __DIR__ . '/../config/database.php';

$email    = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
$password = $_POST['password'] ?? '';
$errors   = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!$email)      $errors[] = 'Email non valide.';
  if (!$password)   $errors[] = 'Mot de passe requis.';

  if (empty($errors)) {
    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      header('Location: dashboard.php');
      exit;
    } else {
      $errors[] = 'Identifiants incorrects.';
    }
  }
}
// Affichage du formulaire et des $errors dessous
?>
```

---

## 4. Changements HTML / attributs à ajouter

* À vos `<form>` d’inscription et de connexion :

  ```html
  <form action="register.php" method="post" class="needs-validation">
    <input type="text" name="username" required data-minlength="3" />
    <input type="email" name="email" required />
    <input type="password" name="password" required data-minlength="6" />
    <button type="submit">S’inscrire</button>
  </form>
  ```

* Charger le script en bas de page :

  ```html
  <script src="/public/js/form-validation.js"></script>
  ```

---

Avec ces fichiers et modifications, tu as :

1. Validation UX + accessibilité côté client.
2. Validation et sécurité côté serveur (email, mot de passe hashé, prepared statements).

Dis-moi si tu veux un exemple complet d’une page d’inscription ou d’autres ajustements !
