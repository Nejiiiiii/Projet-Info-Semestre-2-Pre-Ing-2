// phase3_points1-2.js

/*
  Point 1: Changement de charte graphique (mode clair/sombre)
  - Détection automatique du thème système
  - Bouton qui charge un nouveau fichier CSS sans recharger la page
  - Sauvegarde du choix dans un cookie
*/

// themeSwitcher.js
(function() {
  const themeToggleBtn = document.getElementById('theme-toggle');
  const themeLink = document.getElementById('theme-stylesheet');
  const COOKIE_NAME = 'user-theme';
  const DEFAULT_THEME = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';

  function setTheme(theme) {
    themeLink.setAttribute('href', `css/${theme}.css`);
    document.cookie = `${COOKIE_NAME}=${theme};path=/;max-age=${60*60*24*30}`; // 30 jours
    themeToggleBtn.textContent = theme === 'light' ? 'Activer le mode sombre' : 'Activer le mode clair';
  }

  function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
    return null;
  }

  function initTheme() {
    const saved = getCookie(COOKIE_NAME);
    const theme = saved === 'dark' || saved === 'light' ? saved : DEFAULT_THEME;
    setTheme(theme);
  }

  themeToggleBtn.addEventListener('click', () => {
    const current = getCookie(COOKIE_NAME) || DEFAULT_THEME;
    const next = current === 'light' ? 'dark' : 'light';
    setTheme(next);
  });

  document.addEventListener('DOMContentLoaded', initTheme);
})();

/*
  Point 2: Validation des formulaires côté client
  (inchangé)
*/

// formValidation.js
(function() {
  // ... code de validation inchangé ...
})();
