<div>
    <div>
        <div class="container-fluid p-3">

            <!-- FILTRES + Bouton Ajouter -->
            <div class="card-soft p-3 mb-4 d-flex flex-column flex-md-row gap-2 align-items-center">
                <input type="text" class="form-control flex-grow-1" placeholder="Rechercher..." wire:model.debounce.300ms="search">
                <select class="form-select" wire:model="filterStatus">
                    <option value="">Tous statuts</option>
                    <option value="publie">Publié</option>
                    <option value="brouillon">Brouillon</option>
                </select>
                <button class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#modalFlash" wire:click="resetFields">
                    <i class="bi bi-plus-lg"></i> Ajouter
                </button>
            </div>

            <!-- KPI -->
            <div class="row g-3 mb-4">
                <div class="col-6 col-lg-4">
                    <div class="card-soft kpi d-flex align-items-center gap-3">
                        <div class="icon icon-violet"><i class="bi bi-info-circle"></i></div>
                        <div>
                            <h6>Total Flashs</h6>
                            <span class="fw-bold fs-5">{{ $totalFlashs }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-4">
                    <div class="card-soft kpi d-flex align-items-center gap-3">
                        <div class="icon icon-jaune"><i class="bi bi-cloud-upload"></i></div>
                        <div>
                            <h6>Publiés</h6>
                            <span class="fw-bold fs-5">{{ $totalPublies }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-4">
                    <div class="card-soft kpi d-flex align-items-center gap-3">
                        <div class="icon icon-muted"><i class="bi bi-hourglass-split"></i></div>
                        <div>
                            <h6>Brouillons</h6>
                            <span class="fw-bold fs-5">{{ $totalBrouillons }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABLEAU -->
            <div class="table-responsive card-soft p-3 rounded-4 shadow-sm">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Contenu</th>
                            <th>Catégorie</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($flashs as $i => $f)
                            <tr>
                                <td>{{ $i + 1 + ($flashs->currentPage()-1) * $flashs->perPage() }}</td>
                                <td>{{ $f->contenu }}</td>
                                <td>{{ $f->categorie }}</td>
                                <td>{{ \Carbon\Carbon::parse($f->date_publication)->format('d-m-Y') }}</td>
                                <td>{{ ucfirst($f->statut) }}</td>
                                <td class="d-flex gap-1">
                                    <button class="btn btn-sm btn-warning" wire:click="edit({{ $f->id }})" data-bs-toggle="modal" data-bs-target="#modalFlash">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" wire:click="delete({{ $f->id }})" onclick="return confirm('Supprimer ce flash info ?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    @if($f->statut !== 'publie')
                                        <button class="btn btn-sm btn-success" wire:click="publish({{ $f->id }})">
                                            <i class="bi bi-upload"></i> Publier
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center">Aucun Flash Info</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3 d-flex justify-content-center">
                    {{ $flashs->links('pagination::bootstrap-5') }}
                </div>
            </div>

            <!-- MODAL FLASH -->
            <div wire:ignore.self class="modal fade" id="modalFlash" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form wire:submit.prevent="save">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $flashId ? 'Modifier' : 'Nouvel' }} Flash Info</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label>Contenu</label>
                                    <textarea class="form-control" wire:model.defer="contenu"></textarea>
                                    @error('contenu') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="mb-2">
                                    <label>Catégorie</label>
                                    <input type="text" class="form-control" wire:model.defer="categorie">
                                    @error('categorie') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="mb-2">
                                    <label>Date</label>
                                    <input type="date" class="form-control" wire:model.defer="date_publication">
                                    @error('date_publication') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="mb-2">
                                    <label>Statut</label>
                                    <select class="form-select" wire:model.defer="statut">
                                        <option value="brouillon">Brouillon</option>
                                        <option value="publie">Publié</option>
                                    </select>
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
                    const el = document.getElementById('modalFlash');
                    const modal = bootstrap.Modal.getInstance(el) || new bootstrap.Modal(el);
                    modal.hide();
                });
            });
        </script>

        <style>
            .card-soft { background:#fff; border-radius:1rem; padding:1rem; margin-bottom:1rem; box-shadow:0 2px 8px rgba(0,0,0,.05); }
            .kpi .icon { font-size:1.5rem; padding:10px; border-radius:0.5rem; display:flex; align-items:center; justify-content:center; }
            .icon-violet{background:#7e5bff;color:#fff;}
            .icon-jaune{background:#ffc107;color:#fff;}
            .icon-muted{background:#6c757d;color:#fff;}
        </style>
    </div>

</div>
