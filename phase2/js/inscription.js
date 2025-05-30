function checkPasswordStrength() {
  const passwordInput = document.getElementById("psw");
  const strengthBar = document.getElementById("strength-bar");

  const password = passwordInput.value;
  let strength = 0;

  // Règles de sécurité
  if (password.length >= 8) strength++;               // Longueur
  if (/[A-Z]/.test(password)) strength++;             // Majuscule
  if (/[0-9]/.test(password)) strength++;             // Chiffre
  if (/[^A-Za-z0-9]/.test(password)) strength++;      // Caractère spécial

  // Affichage visuel
  strengthBar.style.height = "10px";
  strengthBar.style.borderRadius = "10px";
  strengthBar.style.transition = "0.3s";

  switch (strength) {
    case 0:
      strengthBar.style.width = "0%";
      strengthBar.style.background = "transparent";
      break;
    case 1:
      strengthBar.style.width = "25%";
      strengthBar.style.background = "red";
      break;
    case 2:
      strengthBar.style.width = "50%";
      strengthBar.style.background = "orange";
      break;
    case 3:
      strengthBar.style.width = "75%";
      strengthBar.style.background = "yellow";
      break;
    case 4:
      strengthBar.style.width = "100%";
      strengthBar.style.background = "green";
      break;
  }
}

