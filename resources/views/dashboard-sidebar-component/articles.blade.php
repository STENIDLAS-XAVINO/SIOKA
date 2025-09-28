{{-- resources/views/dashboard.blade.php (statique, sans base de données) --}}
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard | Articles</title>

  {{-- Icône --}}
  <link rel="icon" href="{{ asset('images/Logo_SIOKA_2.png') }}" type="image/png">
  <link rel="shortcut icon" href="{{ asset('images/Logo_SIOKA_2.png') }}" type="image/png">
  
  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  
  <!-- Police moderne -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

<!-- TOPBAR -->
<header class="topbar py-2">
  @include('dashboard-sidebar-component.topbar')
</header>



<div class="container-fluid app">
  <div class="row">
    <!-- SIDEBAR (desktop) -->
    @include('dashboard-sidebar-component.sidebar')

    </aside>

    <!-- OFFCANVAS (mobile burger) -->
    @include('dashboard-sidebar-component.sidebar_burger')

    <!-- MAIN -->
    <main class="col-md-10 ms-sm-auto px-3 px-md-4 py-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 m-0">Articles</h1>
        <div class="d-flex gap-2">
          <button class="btn btn-outline-secondary btn-sm" id="btnExportTop"><i class="bi bi-download me-1"></i> Exporter</button>
          <button class="btn btn-outline-danger btn-sm" id="btnResetTop"><i class="bi bi-trash me-1"></i> Vider</button>
        </div>
      </div>



      @livewire('articles-crud')

    </main>
  </div>
</div>

<!-- MODAL: AJOUT / ÉDITION -->
<div class="modal fade" id="modalArticle" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form id="formArticle">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">Nouvel article</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="artId">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label">Titre</label>
              <input type="text" id="artTitre" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Date</label>
              <input type="date" id="artDate" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Catégorie</label>
              <select id="artCat" class="form-select" required>
                <option value="" selected disabled>Choisir…</option>
                <option value="gouvernance">Gouvernance</option>
                <option value="societe">Société</option>
                <option value="environnement">Environnement</option>
                <option value="economie">Économie</option>
                <option value="culture">Culture</option>
                <option value="sport">Sport</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Auteur</label>
              <input type="text" id="artAuteur" class="form-control" value="Admin" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Statut</label>
              <select id="artStatut" class="form-select">
                <option value="publie">Publié</option>
                <option value="brouillon">Brouillon</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label">Extrait</label>
              <textarea id="artExtrait" class="form-control" rows="3" placeholder="Résumé court"></textarea>
            </div>
            <div class="col-12">
              <label class="form-label">Lien (démo)</label>
              <input type="url" id="artLien" class="form-control" placeholder="#" value="#">
              <div class="form-text">Dans la maquette, tous les liens restent sur <code>#</code>.</div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Annuler</button>
          <button class="btn btn-primary" type="submit" id="btnSave"><i class="bi bi-check2-circle me-1"></i> Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL: SUPPRESSION -->
<div class="modal fade" id="modalDelete" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Supprimer l’article</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        Voulez-vous vraiment supprimer <strong id="delTitre">cet article</strong> ?
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
        <button class="btn btn-danger" id="btnConfirmDelete"><i class="bi bi-trash me-1"></i> Supprimer</button>
      </div>
    </div>
  </div>
</div>

<!-- TOAST -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index:1080">
  <div id="toast" class="toast align-items-center text-bg-dark border-0" role="status" aria-live="polite" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" id="toastMsg">Action effectuée</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
    </div>
  </div>
</div>



<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
/* ============ Données & utilitaires ============ */
const STORAGE_KEY = 'sioka_articles';
const THEME_KEY = 'sioka_theme';
const $ = (s,root=document)=>root.querySelector(s);
const $all = (s,root=document)=>[...root.querySelectorAll(s)];
const toast = ()=> new bootstrap.Toast($('#toast'),{delay:1700});
const showToast = (msg)=>{ $('#toastMsg').textContent = msg; toast().show(); };
const setTheme = (t)=>{document.documentElement.setAttribute('data-theme', t)};

const catLabel = {gouvernance:'Gouvernance', societe:'Société', environnement:'Environnement', economie:'Économie', culture:'Culture', sport:'Sport'};

function fmtDateFR(iso){
  try{ const d = new Date(iso + 'T00:00:00');
    return d.toLocaleDateString('fr-FR',{day:'2-digit', month:'long', year:'numeric'});
  }catch(e){ return iso }
}

function loadArticles(){
  const raw = localStorage.getItem(STORAGE_KEY);
  if(raw){ return JSON.parse(raw); }
  const seed = [
    {id:1,img:1,cat:"gouvernance",title:"Conseil communal : transparence accrue",excerpt:"Vers une publication ouverte des décisions.",date:"2025-08-13",author:"Admin",status:"publie",url:"#"},
    {id:2,img:2,cat:"societe",title:"Santé : campagne communautaire",excerpt:"Ateliers et dépistage dans les quartiers.",date:"2025-08-12",author:"Rédacteur",status:"publie",url:"#"},
    {id:3,img:3,cat:"environnement",title:"Gestion des déchets : tri pilote",excerpt:"Lancement dans trois arrondissements.",date:"2025-08-12",author:"Admin",status:"publie",url:"#"},
    {id:4,img:4,cat:"economie",title:"Artisanat : label local",excerpt:"Valoriser les produits des coopératives.",date:"2025-08-11",author:"Rédacteur",status:"brouillon",url:"#"},
  ];
  localStorage.setItem(STORAGE_KEY, JSON.stringify(seed));
  return seed;
}
let articles = loadArticles();

/* ============ Rendu ============ */
function renderStats(){
  const total = articles.length;
  const cats = new Set(articles.map(a=>a.cat)).size;
  const pub = articles.filter(a=>a.status==='publie').length;
  const draft = total - pub;
  $('#statTotal').textContent = total;
  $('#statCats').textContent = cats;
  $('#statPub').textContent = pub;
  $('#statDraft').textContent = draft;
  // update charts if present
  if(window.doughnut){ window.doughnut.data.datasets[0].data = [pub, draft]; window.doughnut.update(); }
}

function badgeCat(cat){
  const map = {
    gouvernance:'style="background:#7e5bff;color:#fff"',
    societe:'style="background:#0bb0cf;color:#fff"',
    environnement:'class="badge bg-success"',
    economie:'class="badge bg-warning text-dark"',
    culture:'class="badge bg-danger"',
    sport:'class="badge bg-secondary"'
  };
  const base = map[cat] || 'class="badge bg-dark"';
  return `<span ${base}>${catLabel[cat]||'Actualité'}</span>`;
}

function renderTable(){
  const tbody = $('#tbodyArticles');
  const q = $('#q').value.trim().toLowerCase();
  const fcat = $('#filtreCat').value;
  const fstat = $('#filtreStatut').value;
  let list = articles
    .filter(a => !fcat || a.cat===fcat)
    .filter(a => !fstat || a.status===fstat)
    .filter(a => !q || (a.title + ' ' + (a.excerpt||'') + ' ' + (a.author||'')).toLowerCase().includes(q))
    .sort((a,b)=> b.date.localeCompare(a.date));

  tbody.innerHTML = list.map((a,i)=>`
    <tr data-id="${a.id}">
      <td>${i+1}</td>
      <td class="fw-semibold"><a href="#" class="link-dark">${a.title}</a><div class="small text-secondary">${a.excerpt||''}</div></td>
      <td>${badgeCat(a.cat)}</td>
      <td>${fmtDateFR(a.date)}</td>
      <td>${a.author||'—'}</td>
      <td>
        ${a.status==='publie'
          ? '<span class="badge text-bg-success">Publié</span>'
          : '<span class="badge text-bg-secondary">Brouillon</span>'}
      </td>
      <td class="actions">
        <div class="btn-group">
          <button class="btn btn-sm btn-outline-primary btn-edit"><i class="bi bi-pencil"></i></button>
          <button class="btn btn-sm btn-outline-danger btn-del"><i class="bi bi-trash"></i></button>
          <a class="btn btn-sm btn-outline-secondary" href="#"><i class="bi bi-box-arrow-up-right"></i></a>
        </div>
      </td>
    </tr>
  `).join('');
}

function save(){ localStorage.setItem(STORAGE_KEY, JSON.stringify(articles)); renderStats(); renderTable(); }

/* ============ Actions CRUD ============ */
function openAdd(){
  $('#modalTitle').textContent = 'Nouvel article';
  $('#artId').value = '';
  $('#artTitre').value = '';
  $('#artDate').valueAsDate = new Date();
  $('#artCat').value = '';
  $('#artAuteur').value = 'Admin';
  $('#artStatut').value = 'publie';
  $('#artExtrait').value = '';
  $('#artLien').value = '#';
  new bootstrap.Modal($('#modalArticle')).show();
}

function openEdit(id){
  const a = articles.find(x=>x.id===id); if(!a) return;
  $('#modalTitle').textContent = 'Modifier l’article';
  $('#artId').value = a.id;
  $('#artTitre').value = a.title;
  $('#artDate').value = a.date;
  $('#artCat').value = a.cat;
  $('#artAuteur').value = a.author||'';
  $('#artStatut').value = a.status||'publie';
  $('#artExtrait').value = a.excerpt||'';
  $('#artLien').value = a.url||'#';
  new bootstrap.Modal($('#modalArticle')).show();
}

function submitForm(ev){
  ev.preventDefault();
  const id = $('#artId').value ? Number($('#artId').value) : Date.now();
  const data = {
    id,
    title: $('#artTitre').value.trim(),
    date: $('#artDate').value,
    cat: $('#artCat').value,
    author: $('#artAuteur').value.trim(),
    status: $('#artStatut').value,
    excerpt: $('#artExtrait').value.trim(),
    url: $('#artLien').value || '#'
  };
  const exists = articles.some(a=>a.id===id);
  if(exists){
    articles = articles.map(a => a.id===id ? {...a, ...data} : a);
    showToast('Article mis à jour.');
  }else{
    articles.push({...data});
    showToast('Article ajouté.');
  }
  save();
  bootstrap.Modal.getInstance($('#modalArticle')).hide();
}

let toDelete = null;
function askDelete(id){
  const a = articles.find(x=>x.id===id);
  toDelete = id;
  $('#delTitre').textContent = a ? a.title : 'cet article';
  new bootstrap.Modal($('#modalDelete')).show();
}
function confirmDelete(){
  if(toDelete!==null){
    articles = articles.filter(a=>a.id!==toDelete);
    toDelete=null; save(); showToast('Article supprimé.');
  }
  bootstrap.Modal.getInstance($('#modalDelete')).hide();
}

/* ============ Import/Export/Reset ============ */
function exportJSON(){
  const blob = new Blob([JSON.stringify(articles,null,2)],{type:'application/json'});
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url; a.download = 'sioka-articles.json'; a.click();
  URL.revokeObjectURL(url);
}
function resetData(){
  if(confirm('Réinitialiser la liste aux données de démonstration ?')){
    localStorage.removeItem(STORAGE_KEY);
    articles = loadArticles(); save();
    showToast('Liste réinitialisée.');
  }
}

/* ============ Thème ============ */
function initTheme(){
  const stored = localStorage.getItem(THEME_KEY) || 'light';
  setTheme(stored);
  const icon = stored==='dark' ? 'sun' : 'moon-stars';
  $('#btnTheme').innerHTML = `<i class="bi bi-${icon} me-1"></i> Thème`;
}
function toggleTheme(){
  const current = document.documentElement.getAttribute('data-theme') || 'light';
  const next = current === 'dark' ? 'light' : 'dark';
  setTheme(next); localStorage.setItem(THEME_KEY, next);
  $('#btnTheme').innerHTML = `<i class="bi bi-${next==='dark'?'sun':'moon-stars'} me-1"></i> Thème`;
}

/* ============ Charts (demo) ============ */
function initCharts(){
  const lc = new Chart($('#lineChart'), {
    type: 'line',
    data: { labels: ['Jan','Fév','Mar','Avr','Mai','Juin','Juil','Août'],
      datasets: [{ label:'Articles/mois', data:[3,5,4,7,6,8,9,5], tension:.35, fill:true }]},
    options: { responsive:true, plugins:{legend:{display:false}}, scales:{y:{grid:{color:'rgba(127,127,170,.15)'}}} }
  });
  window.doughnut = new Chart($('#doughnutChart'), {
    type: 'doughnut', data: { labels:['Publiés','Brouillons'], datasets:[{ data:[0,0] }]},
    options: { plugins:{legend:{position:'bottom'}} }
  });
  renderStats();
}

/* ============ Événements ============ */
window.addEventListener('DOMContentLoaded', ()=>{
  initTheme();
  renderStats(); renderTable(); initCharts();

  // Recherche / filtres
  $('#q').addEventListener('input', renderTable);
  $('#filtreCat').addEventListener('change', renderTable);
  $('#filtreStatut').addEventListener('change', renderTable);

  // Boutons globaux
  $('#btnAdd').addEventListener('click', openAdd);
  $('#menuAdd').addEventListener('click', (e)=>{e.preventDefault(); openAdd();});
  const exporters = ['#btnExport','#menuExport','#btnExportTop'];
  exporters.forEach(id=>{ const el=$(id); if(el) el.addEventListener('click', (e)=>{e.preventDefault(); exportJSON();}); });
  const resetters = ['#btnReset','#menuReset','#btnResetTop'];
  resetters.forEach(id=>{ const el=$(id); if(el) el.addEventListener('click', (e)=>{e.preventDefault(); resetData();}); });
  $('#btnTheme').addEventListener('click', toggleTheme);

  // Form
  $('#formArticle').addEventListener('submit', submitForm);
  $('#btnConfirmDelete').addEventListener('click', confirmDelete);

  // Délégation actions table
  $('#tbodyArticles').addEventListener('click', (ev)=>{
    const tr = ev.target.closest('tr'); if(!tr) return; const id = Number(tr.dataset.id);
    if(ev.target.closest('.btn-edit')){ openEdit(id); }
    if(ev.target.closest('.btn-del')){ askDelete(id); }
  });
});
</script>
</body>
</html>
