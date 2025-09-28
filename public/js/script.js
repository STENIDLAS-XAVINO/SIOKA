// script.js - gestion complète header / breaking / reveal / interactions

// --- Helpers ---
const el = s => document.querySelector(s);
const elAll = s => Array.from(document.querySelectorAll(s));

// --- Reveal animation ---
function observeReveal() {
  const els = elAll('.reveal');
  if (!els.length) return;
  const io = new IntersectionObserver((entries, observer) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('in');
        observer.unobserve(e.target);
      }
    });
  }, { threshold: 0.12 });
  els.forEach(n => io.observe(n));
}

// --- Breaking & header positioning ---
// On expose cette fonction globalement pour Livewire et pour le composant blade
function setupBreakingAndHeader() {
  const breaking = document.getElementById('breaking');
  const topbar = document.querySelector('.topbar');
  const navbar = document.querySelector('.navbar');
  const btnBreaking = document.getElementById('btnBreaking');
  const btnClose = document.getElementById('btnCloseBreaking');

  // Safe checks
  if (!topbar || !navbar) {
    // Si header non présent (cas rare), on n'ajuste rien
    return;
  }

  // Ajuste les positions et le padding-top du body selon l'état du breaking
  function adjustPositions() {
    // calc heights (use offsetHeight even if display none: if display none offsetHeight is 0)
    const breakingVisible = breaking && !breaking.classList.contains('d-none') && window.getComputedStyle(breaking).display !== 'none';
    const breakingHeight = (breaking && breakingVisible) ? breaking.offsetHeight : 0;
    const topbarHeight = topbar.offsetHeight;
    const navbarHeight = navbar.offsetHeight;

    // position topbar & navbar
    // topbar under breaking (or at top)
    topbar.style.top = `${breakingHeight}px`;
    // navbar under breaking + topbar
    navbar.style.top = `${breakingHeight + topbarHeight}px`;
    // body padding
    document.body.style.paddingTop = `${breakingHeight + topbarHeight + navbarHeight}px`;
  }

  // Marquee: duplicate content once safely
  function initMarquee() {
    if (!breaking) return;
    const marquee = breaking.querySelector('.marquee');
    if (!marquee) return;
    const content = marquee.querySelector('.marquee-content');
    if (!content) return;
    // Avoid duplicating multiple times
    if (marquee.dataset.duplicated === 'true') return;
    // Duplicate content only if overflow
    if (content.scrollWidth > marquee.clientWidth) {
      content.innerHTML += content.innerHTML;
      marquee.dataset.duplicated = 'true';
      // animate
      let position = 0;
      const speed = 40; // pixels per second
      const widthHalf = content.scrollWidth / 2;
      function step() {
        position -= speed / 60;
        if (Math.abs(position) >= widthHalf) position = 0;
        content.style.transform = `translateX(${position}px)`;
        requestAnimationFrame(step);
      }
      requestAnimationFrame(step);
    }
  }

  // Event handlers
  function bindToggle() {
    if (btnBreaking) {
      // prevent duplicate listeners
      btnBreaking.replaceWith(btnBreaking.cloneNode(true));
      const newBtn = document.getElementById('btnBreaking');
      newBtn?.addEventListener('click', () => {
        if (breaking) {
          breaking.classList.toggle('d-none');
        }
        adjustPositions();
      });
    }
  }

  function bindClose() {
    if (btnClose) {
      btnClose.replaceWith(btnClose.cloneNode(true));
      const newClose = document.getElementById('btnCloseBreaking');
      newClose?.addEventListener('click', () => {
        if (breaking) {
          // smooth hide
          breaking.style.opacity = '0';
          setTimeout(() => {
            breaking.classList.add('d-none');
            breaking.style.opacity = '';
            adjustPositions();
          }, 250);
        }
      });
    }
  }

  // Initial run
  adjustPositions();
  initMarquee();
  bindToggle();
  bindClose();

  // Re-adjust on resize (debounced)
  let resizeTimer;
  window.removeEventListener('resize', adjustPositions);
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      adjustPositions();
      initMarquee(); // init marquee again if necessary
    }, 120);
  });
}

// Small utility for Livewire compatibility
window.setupBreakingFromLivewire = setupBreakingAndHeader;

// --- Essentiel buttons (durée) ---
function setupEssentielButtons() {
  elAll('[data-duration]').forEach(btn => {
    btn.addEventListener('click', (e) => {
      elAll('[data-duration]').forEach(x => x.classList.remove('active'));
      e.currentTarget.classList.add('active');
    });
  });
}

// --- Newsletter ---
function setupNewsletter() {
  const form = document.querySelector('#newsletter form');
  if (!form) return;
  form.addEventListener('submit', (ev) => {
    ev.preventDefault();
    const email = document.getElementById('nlEmail');
    const valid = email && /.+@.+\..+/.test(email.value);
    email.classList.toggle('is-invalid', !valid);
    if (valid) {
      // à remplacer par un appel réel (Livewire/AJAX)
      alert('Merci ! Inscription enregistrée.');
      form.reset();
    }
  });
}

// --- Dark mode toggle ---
function setupDarkMode() {
  const toggle = document.getElementById('toggleDark');
  if (!toggle) return;
  toggle.addEventListener('click', () => {
    document.documentElement.classList.toggle('dark');
  });
}

// --- Dropdowns responsive ---
function setupDropdowns() {
  const isMobile = () => window.innerWidth < 992;
  const dropdowns = document.querySelectorAll('.navbar .dropdown');

  dropdowns.forEach(dropdown => {
    const toggle = dropdown.querySelector('.dropdown-toggle');
    const menu = dropdown.querySelector('.dropdown-menu');
    if (!toggle || !menu) return;

    // Remove previous mobile handlers
    toggle.onclick = null;

    if (isMobile()) {
      toggle.addEventListener('click', function(e) {
        e.preventDefault();
        const isOpen = menu.classList.contains('show');
        document.querySelectorAll('.navbar .dropdown-menu.show').forEach(m => m.classList.remove('show'));
        if (!isOpen) menu.classList.add('show');
      });
    } else {
      menu.classList.remove('show');
    }
  });

  document.addEventListener('click', function(e) {
    if (isMobile() && !e.target.closest('.dropdown')) {
      document.querySelectorAll('.navbar .dropdown-menu.show').forEach(m => m.classList.remove('show'));
    }
  });
}

// --- Init ---
function initAll() {
  observeReveal();
  setupBreakingAndHeader();
  setupEssentielButtons();
  setupNewsletter();
  setupDarkMode();
  setupDropdowns();
}

// On load
document.addEventListener('DOMContentLoaded', initAll);

// Re-run when Livewire updates the DOM
if (window.Livewire) {
  try {
    window.Livewire.hook('message.processed', (message, component) => {
      // Slight delay to allow DOM to settle
      setTimeout(() => {
        initAll();
      }, 40);
    });
  } catch (e) {
    // ignore if Livewire not available
  }
}












