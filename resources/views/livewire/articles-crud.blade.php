<div>

<div class="container-fluid p-3">

    <!-- FILTRES + Bouton Ajouter -->
    <div class="card-soft p-3 mb-4 d-flex flex-column flex-md-row gap-2 align-items-center">
        <input type="text" class="form-control flex-grow-1" placeholder="Rechercher..." wire:model.debounce.300ms="search">
        <select class="form-select" wire:model="filterCat">
            <option value="">Toutes catégories</option>
            @foreach(\App\Models\Article::distinct('cat')->pluck('cat') as $cat)
                <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
            @endforeach
        </select>
        <select class="form-select" wire:model="filterStatus">
            <option value="">Tous statuts</option>
            <option value="publie">Publié</option>
            <option value="brouillon">Brouillon</option>
        </select>
        <button class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#modalArticle" wire:click="resetFields">
            <i class="bi bi-plus-lg"></i> Ajouter
        </button>
    </div>

    <!-- KPI -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-2">
            <div class="card-soft kpi d-flex align-items-center gap-3">
                <div class="icon icon-violet"><i class="bi bi-newspaper"></i></div>
                <div>
                    <h6>Articles</h6>
                    <span class="fw-bold fs-5">{{ $totalArticles }}</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-2">
            <div class="card-soft kpi d-flex align-items-center gap-3">
                <div class="icon icon-bleu"><i class="bi bi-tags"></i></div>
                <div>
                    <h6>Catégories</h6>
                    <span class="fw-bold fs-5">{{ $totalCategories }}</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-2">
            <div class="card-soft kpi d-flex align-items-center gap-3">
                <div class="icon icon-jaune"><i class="bi bi-cloud-upload"></i></div>
                <div>
                    <h6>Publiés</h6>
                    <span class="fw-bold fs-5">{{ $totalPublies }}</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-2">
            <div class="card-soft kpi d-flex align-items-center gap-3">
                <div class="icon icon-muted"><i class="bi bi-hourglass-split"></i></div>
                <div>
                    <h6>Brouillons</h6>
                    <span class="fw-bold fs-5">{{ $totalBrouillons }}</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-2">
            <div class="card-soft kpi d-flex align-items-center gap-3">
                <div class="icon icon-jaune"><i class="bi bi-star-fill"></i></div>
                <div>
                    <h6>Articles à la une</h6>
                    <span class="fw-bold fs-5">{{ $totalUne }}</span>
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
                <th>Image</th>
                <th>Titre</th>
                <th>Catégorie</th>
                <th>Date</th>
                <th>Auteur</th>
                <th>Statut</th>
                <th>À la une</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($articles as $i => $a)
                <tr>
                    <td>{{ $i + 1 + ($articles->currentPage()-1) * $articles->perPage() }}</td>
                    <td>
                        @if($a->image)
                            <img src="{{ asset('storage/'.$a->image) }}" class="img-thumbnail" style="width:60px; height:60px; object-fit:cover;">
                        @else
                            <div style="width:60px;height:60px;background:#f0f0f0;border-radius:6px;"></div>
                        @endif
                    </td>
                    <td>{{ $a->title }}</td>
                    <td>{{ $a->cat }}</td>
                    <td>{{ \Carbon\Carbon::parse($a->date)->format('d-m-Y') }}</td>
                    <td>{{ $a->author }}</td>
                    <td>{{ ucfirst($a->status) }}</td>
                    <td class="text-center">
                        @if($a->is_une)
                            <button class="btn btn-sm btn-warning" wire:click="toggleUne({{ $a->id }})">
                                <i class="bi bi-star-fill"></i> {{ $a->position_une }}
                            </button>
                        @else
                            <button class="btn btn-sm btn-outline-warning" wire:click="toggleUne({{ $a->id }})">
                                <i class="bi bi-star"></i>
                            </button>
                        @endif
                    </td>
                    <td class="d-flex gap-1 flex-wrap">
                        <!-- Modifier -->
                        <button class="btn btn-sm btn-warning" wire:click="edit({{ $a->id }})" data-bs-toggle="modal" data-bs-target="#modalArticle">
                            <i class="bi bi-pencil"></i>
                        </button>

                        <!-- Supprimer -->
                        <button class="btn btn-sm btn-danger" wire:click="delete({{ $a->id }})" onclick="return confirm('Supprimer cet article ?')">
                            <i class="bi bi-trash"></i>
                        </button>

                        <!-- Publier -->
                        @if($a->status !== 'publie')
                            <button class="btn btn-sm btn-success" wire:click="publish({{ $a->id }})">
                                <i class="bi bi-upload"></i> Publier
                            </button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="9" class="text-center">Aucun article</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3 d-flex justify-content-center">
        {{ $articles->links('pagination::bootstrap-5') }}
    </div>
</div>



    <!-- MODAL ARTICLE -->
    <div wire:ignore.self class="modal fade" id="modalArticle" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form wire:submit.prevent="save">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $articleId ? 'Modifier' : 'Nouvel' }} Article</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label>Titre</label>
                            <input type="text" class="form-control" wire:model.defer="title">
                            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col">
                                <label>Date</label>
                                <input type="date" class="form-control" wire:model.defer="date">
                                @error('date') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col">
                                <label>Catégorie</label>
                                <input type="text" class="form-control" wire:model.defer="cat">
                                @error('cat') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col">
                                <label>Auteur</label>
                                <input type="text" class="form-control" wire:model.defer="author">
                                @error('author') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col">
                                <label>Statut</label>
                                <select class="form-select" wire:model.defer="status">
                                    <option value="brouillon">Brouillon</option>
                                    <option value="publie">Publié</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label>Extrait</label>
                            <textarea class="form-control" wire:model.defer="excerpt"></textarea>
                        </div>
                        <div class="mb-2">
                            <label>Contenu</label>
                            <textarea class="form-control" rows="6" wire:model.defer="content"></textarea>
                        </div>
                        <div class="mb-2">
                            <label>Lien</label>
                            <input type="url" class="form-control" wire:model.defer="url">
                        </div>
                        <div class="mb-2">
                            <label>Image (max 2MB)</label>
                            <input type="file" class="form-control" wire:model="image" accept="image/*">
                            <div class="mt-2">
                                <div wire:loading wire:target="image">⏳ Upload en cours...</div>
                                @if($image)
                                    <img src="{{ $image->temporaryUrl() }}" style="max-height:140px;border-radius:6px;">
                                @elseif($imagePreview)
                                    <img src="{{ asset('storage/'.$imagePreview) }}" style="max-height:140px;border-radius:6px;">
                                @endif
                            </div>
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
        const el = document.getElementById('modalArticle');
        const modal = bootstrap.Modal.getInstance(el) || new bootstrap.Modal(el);
        modal.hide();
    });
});
</script>

<style>
.card-soft { background:#fff; border-radius:1rem; padding:1rem; margin-bottom:1rem; box-shadow:0 2px 8px rgba(0,0,0,.05); }
.kpi .icon { font-size:1.5rem; padding:10px; border-radius:0.5rem; display:flex; align-items:center; justify-content:center; }
.icon-violet{background:#7e5bff;color:#fff;}
.icon-bleu{background:#0bb0cf;color:#fff;}
.icon-jaune{background:#ffc107;color:#fff;}
.icon-muted{background:#6c757d;color:#fff;}
</style>



</div>
