function showSaveProfileButton() {
  let saveBtn = document.getElementById("save-profile-btn");
  if (!saveBtn) {
    saveBtn = document.createElement("button");
    saveBtn.id = "save-profile-btn";
    saveBtn.textContent = "💾 Enregistrer le profil";
    saveBtn.className = "payment-button";
    saveBtn.onclick = envoyerProfil;
    document.getElementById("save-profile-placeholder").appendChild(saveBtn);
  }
}

function envoyerProfil() {
  const login = document.getElementById("user-login").textContent;
  const email = document.getElementById("user-email").textContent;

  const form = document.createElement("form");
  form.method = "POST";
  form.action = "traitement/update_profil.php";

  const champLogin = document.createElement("input");
  champLogin.type = "hidden";
  champLogin.name = "login";
  champLogin.value = login;

  const champEmail = document.createElement("input");
  champEmail.type = "hidden";
  champEmail.name = "email";
  champEmail.value = email;

  form.appendChild(champLogin);
  form.appendChild(champEmail);

  document.body.appendChild(form);
  form.submit();
}
