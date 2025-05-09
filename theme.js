const toggle = document.getElementById('theme-toggle');
function applyTheme(name) {
  let link = document.getElementById('theme-link');
  if (!link) {
    link = document.createElement('link');
    link.rel = 'stylesheet';
    link.id = 'theme-link';
    document.head.appendChild(link);
  }
  link.href = `theme-${name}.css`;
  document.cookie = `theme=${name};path=/;max-age=31536000`;
}
// Au chargement : lire le cookie et appliquer
const match = document.cookie.match(/theme=(dark|light)/);
applyTheme(match ? match[1] : 'light');
// Au clic : toggle
toggle.addEventListener('click', () => {
  const current = document.getElementById('theme-link').href.includes('dark') ? 'dark' : 'light';
  applyTheme(current === 'dark' ? 'light' : 'dark');
});
