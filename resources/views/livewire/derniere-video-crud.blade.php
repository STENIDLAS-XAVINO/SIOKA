<div>
    <div class="container py-4">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Gestion des vidéos</h1>
                <button class="btn btn-primary" wire:click="create">
                    <i class="bi bi-plus-lg"></i> Ajouter une vidéo
                </button>
            </div>

            <div class="mb-4">
                <input type="text" class="form-control" placeholder="Rechercher par titre..." wire:model.live.debounce.300ms="search">
            </div>

            <div class="row g-4">
                @forelse($videos as $video)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="card h-100 border-0 shadow-sm video-card">
                            <div class="embed-responsive embed-responsive-16by9 bg-dark rounded-top position-relative">
                                <a href="https://www.youtube.com/watch?v={{ $video->youtube_id }}" target="_blank" rel="noopener noreferrer" class="d-block w-100 h-100">
                                    <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/maxresdefault.jpg" class="card-img-top embed-responsive-item" alt="{{ $video->title }}">
                                </a>
                                <div class="badge-overlay">
                                    <span class="badge {{ $video->is_published ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $video->is_published ? 'Publié' : 'Brouillon' }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-truncate mb-2">{{ $video->title }}</h5>
                                <p class="card-text text-muted small mb-3">
                                    <i class="bi bi-calendar"></i> Publié le {{ $video->created_at->format('d/m/Y') }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-outline-warning" wire:click="edit({{ $video->id }})" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" wire:click="deleteConfirm({{ $video->id }})" title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    <button class="btn btn-sm {{ $video->is_published ? 'btn-success' : 'btn-outline-secondary' }}" wire:click="togglePublish({{ $video->id }})">
                                        {{ $video->is_published ? 'Dépublier' : 'Publier' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Aucune vidéo trouvée.</p>
                        <i class="bi bi-camera-video" style="font-size: 3rem;"></i>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $videos->links() }}
    </div>

    <div wire:ignore.self class="modal fade" id="video-form" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit="save">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $video ? 'Modifier la vidéo' : 'Ajouter une vidéo' }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Titre</label>
                            <input type="text" class="form-control" id="title" wire:model="title">
                            @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="youtube_id" class="form-label">ID YouTube</label>
                            <input type="text" class="form-control" id="youtube_id" wire:model="youtube_id">
                            @error('youtube_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            <div class="form-text mt-2">Exemple : Pour <b>https://www.youtube.com/watch?v=</b><u>dQw4w9WgXcQ</u>, l'ID est <u>dQw4w9WgXcQ</u>.</div>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_published" wire:model="is_published">
                            <label class="form-check-label" for="is_published">Publier la vidéo</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                            <span wire:loading.remove>Enregistrer</span>
                            <span wire:loading>Enregistrement...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const videoModal = new bootstrap.Modal(document.getElementById('video-form'));

        Livewire.on('open-modal', () => {
            videoModal.show();
        });

        Livewire.on('close-modal', () => {
            videoModal.hide();
        });

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
@endpush

<style>
    .video-card .embed-responsive {
        position: relative;
        overflow: hidden;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
        height: 0;
    }
    .video-card .embed-responsive-item {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease-in-out;
    }
    .video-card:hover .embed-responsive-item {
        transform: scale(1.05);
    }
    .video-card .badge-overlay {
        position: absolute;
        top: 1rem;
        right: 1rem;
        z-index: 10;
    }
</style>
</div>