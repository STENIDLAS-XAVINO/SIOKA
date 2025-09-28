
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard | Flash Infos</title>

    {{-- Icône --}}
    <link rel="icon" href="{{ asset('images/Logo_SIOKA_2.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('images/Logo_SIOKA_2.png') }}" type="image/png">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    @livewireStyles
</head>
<body>

<!-- TOPBAR -->
<header class="topbar py-2">
  @include('dashboard-sidebar-component.topbar')
</header>

<div class="container-fluid app">
    <div class="row h-100">
        @include('dashboard-sidebar-component.sidebar')

        </aside>

        @include('dashboard-sidebar-component.sidebar_burger')

        <main class="col-md-10 ms-sm-auto px-3 px-md-4 py-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h4 m-0">Flash Infos</h1>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm" id="btnExportTop"><i class="bi bi-download me-1"></i> Exporter</button>
                    <button class="btn btn-outline-danger btn-sm" id="btnResetTop"><i class="bi bi-trash me-1"></i> Vider</button>
                </div>
            </div>

            @livewire('flash-infos-crud')
            
        </main>
    </div>
</div>

<div class="modal fade" id="modalFlash" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form id="formFlash">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Nouveau Flash Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="flashId">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Contenu</label>
                            <textarea id="flashContenu" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date de publication</label>
                            <input type="date" id="flashDate" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Statut</label>
                            <select id="flashStatut" class="form-select">
                                <option value="publie">Publié</option>
                                <option value="brouillon">Brouillon</option>
                            </select>
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

<div class="modal fade" id="modalDelete" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Supprimer le Flash Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                Voulez-vous vraiment supprimer <strong id="delContenu">ce flash info</strong> ?
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                <button class="btn btn-danger" id="btnConfirmDelete"><i class="bi bi-trash me-1"></i> Supprimer</button>
            </div>
        </div>
    </div>
</div>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index:1080">
    <div id="toast" class="toast align-items-center text-bg-dark border-0" role="status" aria-live="polite" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="toastMsg">Action effectuée</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    /* ============ Données & utilitaires ============ */
    const STORAGE_KEY = 'sioka_flash_infos';
    const THEME_KEY = 'sioka_theme';
    const $ = (s, root = document) => root.querySelector(s);
    const $all = (s, root = document) => [...root.querySelectorAll(s)];
    const toast = () => new bootstrap.Toast($('#toast'), { delay: 1700 });
    const showToast = (msg) => { $('#toastMsg').textContent = msg; toast().show(); };
    const setTheme = (t) => { document.documentElement.setAttribute('data-theme', t) };

    function fmtDateFR(iso) {
        try {
            const d = new Date(iso + 'T00:00:00');
            return d.toLocaleDateString('fr-FR', { day: '2-digit', month: 'long', year: 'numeric' });
        } catch (e) {
            return iso
        }
    }

    function loadFlashInfos() {
        const raw = localStorage.getItem(STORAGE_KEY);
        if (raw) {
            return JSON.parse(raw);
        }
        const seed = [
            { id: 1, contenu: "Alerte : Fermeture de l'avenue principale pour travaux.", date: "2025-09-17", status: "publie" },
            { id: 2, contenu: "Événement : Fête de la ville ce samedi 20 septembre.", date: "2025-09-16", status: "publie" },
            { id: 3, contenu: "Sécurité : Nouvelles caméras de surveillance installées.", date: "2025-09-15", status: "brouillon" },
        ];
        localStorage.setItem(STORAGE_KEY, JSON.stringify(seed));
        return seed;
    }
    let flashInfos = loadFlashInfos();

    /* ============ Rendu ============ */
    function renderTable() {
        const tbody = $('#tbodyFlashInfos');
        let list = flashInfos.sort((a, b) => b.date.localeCompare(a.date));

        tbody.innerHTML = list.map((f, i) => `
            <tr data-id="${f.id}">
                <td>${i + 1}</td>
                <td>${f.contenu}</td>
                <td>${fmtDateFR(f.date)}</td>
                <td>
                    ${f.status === 'publie'
                        ? '<span class="badge text-bg-success">Publié</span>'
                        : '<span class="badge text-bg-secondary">Brouillon</span>'}
                </td>
                <td class="actions">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-outline-primary btn-edit"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-outline-danger btn-del"><i class="bi bi-trash"></i></button>
                    </div>
                </td>
            </tr>
        `).join('');
    }

    function save() { localStorage.setItem(STORAGE_KEY, JSON.stringify(flashInfos)); renderTable(); }

    /* ============ Actions CRUD ============ */
    function openAdd() {
        $('#modalTitle').textContent = 'Nouveau Flash Info';
        $('#flashId').value = '';
        $('#flashContenu').value = '';
        $('#flashDate').valueAsDate = new Date();
        $('#flashStatut').value = 'publie';
        new bootstrap.Modal($('#modalFlash')).show();
    }

    function openEdit(id) {
        const f = flashInfos.find(x => x.id === id);
        if (!f) return;
        $('#modalTitle').textContent = 'Modifier le Flash Info';
        $('#flashId').value = f.id;
        $('#flashContenu').value = f.contenu;
        $('#flashDate').value = f.date;
        $('#flashStatut').value = f.status || 'publie';
        new bootstrap.Modal($('#modalFlash')).show();
    }

    function submitForm(ev) {
        ev.preventDefault();
        const id = $('#flashId').value ? Number($('#flashId').value) : Date.now();
        const data = {
            id,
            contenu: $('#flashContenu').value.trim(),
            date: $('#flashDate').value,
            status: $('#flashStatut').value
        };
        const exists = flashInfos.some(f => f.id === id);
        if (exists) {
            flashInfos = flashInfos.map(f => f.id === id ? { ...f, ...data } : f);
            showToast('Flash Info mis à jour.');
        } else {
            flashInfos.push({ ...data });
            showToast('Flash Info ajouté.');
        }
        save();
        bootstrap.Modal.getInstance($('#modalFlash')).hide();
    }

    let toDelete = null;
    function askDelete(id) {
        const f = flashInfos.find(x => x.id === id);
        toDelete = id;
        $('#delContenu').textContent = f ? f.contenu : 'ce flash info';
        new bootstrap.Modal($('#modalDelete')).show();
    }

    function confirmDelete() {
        if (toDelete !== null) {
            flashInfos = flashInfos.filter(f => f.id !== toDelete);
            toDelete = null;
            save();
            showToast('Flash Info supprimé.');
        }
        bootstrap.Modal.getInstance($('#modalDelete')).hide();
    }

    /* ============ Import/Export/Reset ============ */
    function exportJSON() {
        const blob = new Blob([JSON.stringify(flashInfos, null, 2)], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'sioka-flash-infos.json';
        a.click();
        URL.revokeObjectURL(url);
    }
    function resetData() {
        if (confirm('Réinitialiser la liste aux données de démonstration ?')) {
            localStorage.removeItem(STORAGE_KEY);
            flashInfos = loadFlashInfos();
            save();
            showToast('Liste réinitialisée.');
        }
    }

    /* ============ Thème ============ */
    function initTheme() {
        const stored = localStorage.getItem(THEME_KEY) || 'light';
        setTheme(stored);
        const icon = stored === 'dark' ? 'sun' : 'moon-stars';
        $('#btnTheme').innerHTML = `<i class="bi bi-${icon} me-1"></i> Thème`;
    }
    function toggleTheme() {
        const current = document.documentElement.getAttribute('data-theme') || 'light';
        const next = current === 'dark' ? 'light' : 'dark';
        setTheme(next);
        localStorage.setItem(THEME_KEY, next);
        $('#btnTheme').innerHTML = `<i class="bi bi-${next === 'dark' ? 'sun' : 'moon-stars'} me-1"></i> Thème`;
    }

    /* ============ Événements ============ */
    window.addEventListener('DOMContentLoaded', () => {
        initTheme();
        renderTable();

        // Boutons globaux
        $('#btnAdd').addEventListener('click', openAdd);
        $('#menuAdd').addEventListener('click', (e) => { e.preventDefault(); openAdd(); });
        const exporters = ['#btnExportTop', '#menuExport'];
        exporters.forEach(id => {
            const el = $(id);
            if (el) el.addEventListener('click', (e) => { e.preventDefault(); exportJSON(); });
        });
        const resetters = ['#btnResetTop', '#menuReset'];
        resetters.forEach(id => {
            const el = $(id);
            if (el) el.addEventListener('click', (e) => { e.preventDefault(); resetData(); });
        });
        $('#btnTheme').addEventListener('click', toggleTheme);

        // Form
        $('#formFlash').addEventListener('submit', submitForm);
        $('#btnConfirmDelete').addEventListener('click', confirmDelete);

        // Délégation actions table
        $('#tbodyFlashInfos').addEventListener('click', (ev) => {
            const tr = ev.target.closest('tr');
            if (!tr) return;
            const id = Number(tr.dataset.id);
            if (ev.target.closest('.btn-edit')) { openEdit(id); }
            if (ev.target.closest('.btn-del')) { askDelete(id); }
        });
    });
</script>
</body>
</html>