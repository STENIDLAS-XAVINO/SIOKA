<div>
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h3 class="h5 m-0">Dernières actualités</h3>
        <div class="btn-group" role="group" aria-label="Filtre">
            <button 
                class="btn btn-outline-secondary btn-sm @if($selectedCategory === 'toutes') active @endif" 
                wire:click="setCategory('toutes')"
            >
                Toutes
            </button>
            @foreach($categories as $cat)
            <button 
                class="btn btn-outline-secondary btn-sm @if($selectedCategory === $cat) active @endif" 
                wire:click="setCategory('{{ $cat }}')"
            >
                {{ ucfirst($cat) }}
            </button>
            @endforeach
        </div>
    </div>
    
    <div class="row g-3">
        @forelse($articles as $article)
        <div class="col-md-4" wire:key="{{ $article->id }}">
            <div class="card shadow-sm h-100 reveal">
                @if($article->image)
                <img src="{{ asset('storage/' . $article->image) }}" class="card-img-top img-fluid" alt="{{ $article->title }}">
                @endif
                <div class="card-body d-flex flex-column">
                    {{-- Étiquette de catégorie avec un style coloré --}}
                    <span class="badge rounded-pill text-bg-info mb-2">{{ ucfirst($article->cat) }}</span>
                    <h5 class="card-title">{{ $article->title }}</h5>
                    <p class="card-text flex-grow-1">{{ $article->excerpt }}</p>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <small class="text-body-secondary">
                        <i class="bi bi-calendar3 me-1"></i>
                        {{ \Carbon\Carbon::parse($article->date)->format('d/m/Y') }}
                    </small>
                    <a href="{{ route('articles.show', $article->id) }}" class="btn btn-sm btn-primary">Lire la suite</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center my-5">
            <div class="p-5 border rounded-3 text-secondary bg-light">
                <i class="bi bi-info-circle display-4"></i>
                <p class="mt-3 fs-5">Aucun article ne correspond à cette catégorie pour le moment.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>