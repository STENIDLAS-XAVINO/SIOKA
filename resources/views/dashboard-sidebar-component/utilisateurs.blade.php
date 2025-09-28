<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard | Utilisateurs</title>

    {{-- Icône --}}
    <link rel="icon" href="{{ asset('images/Logo_SIOKA_2.png') }}" type="image/png">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Police moderne -->
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
    <div class="row">
        @include('dashboard-sidebar-component.sidebar')

        <main class="col-md-10 ms-sm-auto px-3 px-md-4 py-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h4 m-0">Utilisateurs</h1>
                <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary btn-sm" id="btnExportTop"><i class="bi bi-download me-1"></i> Exporter</button>
                <button class="btn btn-outline-danger btn-sm" id="btnResetTop"><i class="bi bi-trash me-1"></i> Vider</button>
                </div>
            </div>

            {{-- Composant Livewire CRUD --}}
            @livewire('users-crud')

        </main>
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@livewireScripts
<script>
    document.addEventListener('livewire:load', function () {
        // Fermer le modal automatiquement après sauvegarde
        Livewire.on('closeModal', () => {
            const el = document.getElementById('modalUser');
            if(el){
                const modal = bootstrap.Modal.getInstance(el) || new bootstrap.Modal(el);
                modal.hide();
            }
        });
    });
</script>

<style>
.card-soft { 
    background:#fff; 
    border-radius:1rem; 
    padding:1rem; 
    margin-bottom:1rem; 
    box-shadow:0 2px 8px rgba(0,0,0,.05); 
}
</style>

</body>
</html>
