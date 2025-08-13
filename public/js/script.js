// --- Données fictives ---
const slides = [
  {img: 101, title:"Gouvernance : feuille de route 2025", cat:"Gouvernance"},
  {img: 102, title:"Environnement : initiatives locales", cat:"Environnement"},
  {img: 103, title:"Économie : PME et innovation", cat:"Économie"},
];

const essentielData = [
  {title:"Société : éducation inclusive", time:"Il y a 12 min"},
  {title:"Gouvernance : budget participatif", time:"Il y a 45 min"},
  {title:"Environnement : reboisement", time:"Il y a 1 h"},
  {title:"Économie : micro‑crédit", time:"Il y a 2 h"},
  {title:"Culture : festival citoyen", time:"Il y a 3 h"},
];

const actus = [
  {img:1,cat:"gouvernance",title:"Conseil communal : transparence accrue",excerpt:"Vers une publication ouverte des décisions.",date:"13 août 2025"},
  {img:2,cat:"societe",title:"Santé : campagne communautaire",excerpt:"Ateliers et dépistage dans les quartiers.",date:"12 août 2025"},
  {img:3,cat:"environnement",title:"Gestion des déchets : tri pilote",excerpt:"Lancement dans trois arrondissements.",date:"12 août 2025"},
  {img:4,cat:"economie",title:"Artisanat : label local",excerpt:"Valoriser les produits des coopératives.",date:"11 août 2025"},
  {img:5,cat:"culture",title:"Bibliothèques de rue",excerpt:"Lecture pour tous les âges.",date:"11 août 2025"},
  {img:6,cat:"sport",title:"Tournoi inter‑quartiers",excerpt:"Fair‑play et inclusion.",date:"10 août 2025"},
];

const gallery = Array.from({length:8}).map((_,i)=>({img: 300+i}));

// --- Helpers ---
const el = s=>document.querySelector(s);
const elAll = s=>Array.from(document.querySelectorAll(s));

// Carousel
function renderCarousel(){
  const wrap = el('#carouselInner');
  wrap.innerHTML = slides.map((s,i)=>`
    <div class="carousel-item ${i===0?'active':''}">
      <img class="d-block w-100" src="https://picsum.photos/1280/720?random=${s.img}" alt="${s.title}">
      <div class="carousel-caption d-none d-md-block text-start">
        <span class="badge" style="background:var(--violet)">${s.cat}</span>
        <h5>${s.title}</h5>
      </div>
    </div>`).join('');
}

// Essentiel
function renderEssentiel(){
  const wrap = el('#essentielList');
  wrap.innerHTML = '';
  essentielData.forEach(item=>{
    const a = document.createElement('a');
    a.href = '#';
    a.className = 'list-group-item list-group-item-action';
    a.innerHTML = `
      <div class="d-flex w-100 justify-content-between">
        <h6 class="mb-1">${item.title}</h6>
        <small class="text-muted">${item.time}</small>
      </div>
      <p class="mb-1 small text-secondary">Résumé court pour situer le contexte.</p>`;
    wrap.appendChild(a);
  });
}

// Cartes article
function cardArticle({img,cat,title,excerpt,date}){
  const label = {
    gouvernance:'Gouvernance',
    societe:'Société',
    environnement:'Environnement',
    economie:'Économie',
    culture:'Culture',
    sport:'Sport'
  }[cat] || 'Actualité';

  return `<div class="col-12 col-md-6 col-lg-4 reveal">
    <article class="card card-article rounded-4 overflow-hidden h-100">
      <img src="https://picsum.photos/600/360?random=${100+img}" alt="${title}" class="card-img-top">
      <div class="card-body d-flex flex-column">
        <span class="badge badge-cat mb-2">${label}</span>
        <h6 class="mb-1">${title}</h6>
        <p class="small text-secondary flex-grow-1">${excerpt}</p>
        <div class="d-flex justify-content-between align-items-center article-meta small">
          <span><i class="bi bi-calendar3 me-1"></i>${date}</span>
          <a href="#" class="stretched-link">Lire</a>
        </div>
      </div>
    </article>
  </div>`;
}

// Actus
function renderActus(filter='toutes'){
  const grid = el('#actusGrid');
  grid.innerHTML = actus
    .filter(a=> filter==='toutes' ? true : a.cat===filter)
    .map(cardArticle)
    .join('');
  observeReveal();
}

// Gallery
function renderGallery(){
  const wrap = el('#galleryWrap');
  wrap.innerHTML = gallery.map(g=>
    `<div class="col-6 col-md-3">
      <img class="w-100" src="https://picsum.photos/600/360?random=${g.img}" alt="Album">
    </div>`).join('');
}

// Search
function search(query){
  const q = query.toLowerCase();
  return actus.filter(a=> [a.title,a.excerpt].join(' ').toLowerCase().includes(q));
}

// Animation reveal
function observeReveal(){
  const io = new IntersectionObserver((entries)=>{
    entries.forEach(e=>{
      if(e.isIntersecting){
        e.target.classList.add('in');
        io.unobserve(e.target);
      }
    });
  },{threshold:.12});
  elAll('.reveal').forEach(n=>io.observe(n));
}

// Initialisation
document.addEventListener('DOMContentLoaded', () => {
  renderCarousel();
  renderEssentiel();
  renderActus();
  renderGallery();
  observeReveal();

  // Breaking toggle
  const breaking = el('#breaking');
  el('#btnBreaking').addEventListener('click', ()=>{
    breaking.classList.toggle('d-none');
    el('#btnBreaking').setAttribute('aria-expanded', String(!breaking.classList.contains('d-none')));
  });
  el('#btnCloseBreaking').addEventListener('click', ()=>breaking.classList.add('d-none'));

  // Filtres actus
  elAll('[data-cat]').forEach(btn => btn.addEventListener('click', (e)=>{
    elAll('[data-cat]').forEach(x=>x.classList.remove('active'));
    e.currentTarget.classList.add('active');
    renderActus(e.currentTarget.dataset.cat);
  }));

  // Essentiel durée (exemple d'interaction visuelle)
  elAll('[data-duration]').forEach(btn => btn.addEventListener('click', (e)=>{
    elAll('[data-duration]').forEach(x=>x.classList.remove('active'));
    e.currentTarget.classList.add('active');
  }));

  // Newsletter validation
  const form = document.querySelector('#newsletter form');
  form.addEventListener('submit', (ev)=>{
    ev.preventDefault();
    const email = document.getElementById('nlEmail');
    const valid = email.value && /.+@.+\..+/.test(email.value);
    email.classList.toggle('is-invalid', !valid);
    if(valid){
      alert('Merci ! Inscription enregistrée.');
      form.reset();
    }
  });

  // Recherche
  el('#searchInput').addEventListener('input', (ev)=>{
    const q = ev.target.value.trim();
    const results = q ? search(q) : [];
    const list = el('#searchResults');
    list.innerHTML = results.map(r=>
      `<a href="#" class="list-group-item list-group-item-action">${r.title}</a>`
    ).join('');
  });

  // Dark mode
  el('#toggleDark').addEventListener('click', ()=>{
    document.documentElement.classList.toggle('dark');
  });

  // Dropdowns responsive (hover desktop, click mobile)
  const isMobile = () => window.innerWidth < 992;

  function setupDropdowns(){
    const dropdowns = document.querySelectorAll('.navbar .dropdown');

    dropdowns.forEach(dropdown => {
      const toggle = dropdown.querySelector('.dropdown-toggle');
      const menu = dropdown.querySelector('.dropdown-menu');
      toggle.onclick = null;

      if (isMobile()) {
        toggle.addEventListener('click', function(e){
          e.preventDefault(); // empêche redirection immédiate
          const isOpen = menu.classList.contains('show');

          // Ferme tous les autres menus ouverts
          document.querySelectorAll('.navbar .dropdown-menu.show').forEach(m => m.classList.remove('show'));

          if (!isOpen) {
            menu.classList.add('show');
          } else {
            menu.classList.remove('show');
          }
        });
      } else {
        // Desktop: aucune action JS, hover via CSS
        menu.classList.remove('show');
      }
    });

    // Fermer dropdowns au clic hors menu (mobile uniquement)
    document.addEventListener('click', function(e){
      if (isMobile() && !e.target.closest('.dropdown')) {
        document.querySelectorAll('.navbar .dropdown-menu.show').forEach(m => m.classList.remove('show'));
      }
    });
  }

  setupDropdowns();
  window.addEventListener('resize', setupDropdowns);
});
