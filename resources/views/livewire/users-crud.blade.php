<div>

<div class="container-fluid p-3">

    <!-- FILTRES + Bouton Ajouter -->
    <div class="card-soft p-3 mb-4 d-flex flex-column flex-md-row gap-2 align-items-center">
        <input type="text" class="form-control flex-grow-1" placeholder="Rechercher..." wire:model.debounce.300ms="search">
        <select class="form-select" wire:model="filterRole">
            <option value="">Tous rôles</option>
            <option value="admin">Admin</option>
            <option value="editeur">Éditeur</option>
            <option value="membre">Membre</option>
        </select>
        <button class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#modalUser" wire:click="resetFields">
            <i class="bi bi-plus-lg"></i> Ajouter
        </button>
    </div>

    <!-- TABLEAU UTILISATEURS -->
    <div class="table-responsive card-soft p-3 rounded-4 shadow-sm">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Inscrit le</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $i => $u)
                    <tr>
                        <td>{{ $i + 1 + ($users->currentPage()-1) * $users->perPage() }}</td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>
                            @if($u->role == 'admin') <span class="badge bg-primary">Admin</span>
                            @elseif($u->role == 'editeur') <span class="badge bg-info">Éditeur</span>
                            @else <span class="badge bg-secondary">Membre</span>
                            @endif
                        </td>
                        <td>{{ $u->created_at->format('d-m-Y') }}</td>
                        <td class="d-flex gap-1 flex-wrap">
                            <button class="btn btn-sm btn-warning" wire:click="edit({{ $u->id }})" data-bs-toggle="modal" data-bs-target="#modalUser">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" wire:click="confirmDelete({{ $u->id }})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">Aucun utilisateur</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3 d-flex justify-content-center">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- MODAL AJOUT / ÉDITION UTILISATEUR -->
    <div wire:ignore.self class="modal fade" id="modalUser" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="save">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $userId ? 'Modifier' : 'Nouvel' }} Utilisateur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label>Nom</label>
                            <input type="text" class="form-control" wire:model.defer="name">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-2">
                            <label>Email</label>
                            <input type="email" class="form-control" wire:model.defer="email">
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-2">
                            <label>Rôle</label>
                            <select class="form-select" wire:model.defer="role">
                                <option value="membre">Membre</option>
                                <option value="editeur">Éditeur</option>
                                <option value="admin">Admin</option>
                            </select>
                            @error('role') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-2">
                            <label>Mot de passe</label>
                            <input type="password" class="form-control" wire:model.defer="password">
                            <small class="text-muted">Laissez vide pour ne pas changer</small>
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-2">
                            <label>Confirmation mot de passe</label>
                            <input type="password" class="form-control" wire:model.defer="password_confirmation">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                            <span wire:loading.remove>Enregistrer</span>
                            <span wire:loading>Enregistrement…</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    window.addEventListener('closeModal', function () {
        const el = document.getElementById('modalUser');
        const modal = bootstrap.Modal.getInstance(el) || new bootstrap.Modal(el);
        modal.hide();
    });

    // SweetAlert confirmation
    window.addEventListener('swal:confirm', event => {
        if (confirm(event.detail.message)) {
            Livewire.emit('delete', event.detail.id)
        }
    });
});
</script>

<style>
.card-soft { background:#fff; border-radius:1rem; padding:1rem; margin-bottom:1rem; box-shadow:0 2px 8px rgba(0,0,0,.05); }
</style>
