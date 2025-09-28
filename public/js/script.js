// --- Helpers ---
const el = s => document.querySelector(s);
const elAll = s => Array.from(document.querySelectorAll(s));

// Animation reveal
function observeReveal() {
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('in');
        io.unobserve(e.target);
      }
    });
  }, {
    threshold: .12
  });
  elAll('.reveal').forEach(n => io.observe(n));
}

// Initialisation
document.addEventListener('DOMContentLoaded', () => {
  // Exécuter l'animation d'apparition
  observeReveal();

  // Breaking toggle
  const breaking = el('#breaking');
  if (breaking) {
    el('#btnBreaking').addEventListener('click', () => {
      breaking.classList.toggle('d-none');
      el('#btnBreaking').setAttribute('aria-expanded', String(!breaking.classList.contains('d-none')));
    });
    el('#btnCloseBreaking').addEventListener('click', () => breaking.classList.add('d-none'));
  }

  // Essentiel durée (exemple d'interaction visuelle)
  elAll('[data-duration]').forEach(btn => btn.addEventListener('click', (e) => {
    elAll('[data-duration]').forEach(x => x.classList.remove('active'));
    e.currentTarget.classList.add('active');
  }));

  // Newsletter validation
  const form = document.querySelector('#newsletter form');
  if (form) {
    form.addEventListener('submit', (ev) => {
      ev.preventDefault();
      const email = document.getElementById('nlEmail');
      const valid = email.value && /.+@.+\..+/.test(email.value);
      email.classList.toggle('is-invalid', !valid);
      if (valid) {
        alert('Merci ! Inscription enregistrée.');
        form.reset();
      }
    });
  }

  // Recherche
  const searchInput = el('#searchInput');
  if (searchInput) {
    searchInput.addEventListener('input', (ev) => {
      const q = ev.target.value.trim();
      const list = el('#searchResults');
      if (list) {
        // La logique de recherche doit être gérée par Livewire ou une API
        // Vous pouvez envoyer la requête de recherche ici si nécessaire
        // Par exemple : Livewire.emit('search', q);
      }
    });
  }

  // Dark mode
  const toggleDark = el('#toggleDark');
  if (toggleDark) {
    toggleDark.addEventListener('click', () => {
      document.documentElement.classList.toggle('dark');
    });
  }

  // Dropdowns responsive (hover desktop, click mobile)
  const isMobile = () => window.innerWidth < 992;

  function setupDropdowns() {
    const dropdowns = document.querySelectorAll('.navbar .dropdown');

    dropdowns.forEach(dropdown => {
      const toggle = dropdown.querySelector('.dropdown-toggle');
      const menu = dropdown.querySelector('.dropdown-menu');
      if (toggle) toggle.onclick = null;

      if (isMobile()) {
        if (toggle) {
          toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const isOpen = menu.classList.contains('show');
            document.querySelectorAll('.navbar .dropdown-menu.show').forEach(m => m.classList.remove('show'));
            if (!isOpen) {
              menu.classList.add('show');
            } else {
              menu.classList.remove('show');
            }
          });
        }
      } else {
        if (menu) menu.classList.remove('show');
      }
    });

    document.addEventListener('click', function(e) {
      if (isMobile() && !e.target.closest('.dropdown')) {
        document.querySelectorAll('.navbar .dropdown-menu.show').forEach(m => m.classList.remove('show'));
      }
    });
  }

  setupDropdowns();
  window.addEventListener('resize', setupDropdowns);
});