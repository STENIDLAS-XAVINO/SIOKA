<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard | Utilisateurs</title>

    {{-- Icône --}}
    <link rel="icon" href="{{ asset('images/Logo_SIOKA_2.png') }}" type="image/png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet"> {{-- Ajout du CSS SweetAlert --}}

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    @livewireStyles
</head>
<body>

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
            @livewire('derniere-video-crud')
            
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> {{-- SweetAlert JS doit être ici --}}
@livewireScripts
<script>
    document.addEventListener('livewire:initialized', function () {
        // Initialisation du modal Bootstrap une seule fois
        const videoModal = new bootstrap.Modal(document.getElementById('video-form'));

        // Écouteur pour ouvrir le modal
        Livewire.on('open-modal', () => {
            videoModal.show();
        });

        // Écouteur pour fermer le modal
        Livewire.on('close-modal', () => {
            videoModal.hide();
        });

        // Gestion de la confirmation de suppression avec SweetAlert2
        window.deleteConfirm = function (videoId) {
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Cette action est irréversible !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimer !',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('delete-video', { videoId: videoId });
                }
            });
        }
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