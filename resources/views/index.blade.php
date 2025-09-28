<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Accueil | SIOKA</title>
  <meta name="description" content="Maquette HTML/CSS/JS + Bootstrap inspirée de sioka.org, avec Webradio, WebTV, rubriques citoyennes et actualités." />
  {{-- Icône --}}
  <link rel="icon" href="{{ asset('images/Logo_SIOKA_2.png') }}" type="image/png">
  <link rel="shortcut icon" href="{{ asset('images/Logo_SIOKA_2.png') }}" type="image/png">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
  @livewireStyles
</head>
<body>
  @include('composants.header')

  {{-- Slide Injecté --}}
  <header class="hero pt-4 pb-3">
    <div class="container">
      <div class="row g-4 align-items-stretch">
      <div class="col-lg-7">
        <div id="heroCarousel" class="carousel slide ratio ratio-16x9" data-bs-ride="carousel">
          <div class="carousel-inner">
            @forelse($une as $article)
            <div class="carousel-item @if ($loop->first) active @endif">
              <a href="{{ route('articles.show', $article->id) }}" class="stretched-link">
                @if($article->image)
                <img src="{{ asset('storage/' . $article->image) }}" class="d-block w-100" alt="{{ $article->title }}" style="object-fit: cover; height: 100%;">
                @endif
              </a>
              <div class="carousel-caption d-none d-md-flex flex-column justify-content-center align-items-center h-100">
                <div class="p-3 rounded-3" style="backdrop-filter: blur(5px); background-color: rgba(0, 0, 0, 0.4);">
                  <span class="badge rounded-pill text-bg-secondary mb-2">{{ ucfirst($article->cat) }}</span>
                  <h5 class="text-white">{{ $article->title }}</h5>
                  <p class="text-white d-none d-lg-block">{{ $article->excerpt }}</p>
                </div>
              </div>
            </div>
            @empty
            {{-- <div class="carousel-item active">
              <img src="https://via.placeholder.com/1200x800.png?text=Pas+d'articles" class="d-block w-100" alt="Pas d'articles" style="object-fit: cover; height: 100%;">
              <div class="carousel-caption d-none d-md-block">
                <h5>Aucun article à la une</h5>
                <p>Veuillez ajouter des articles pour les afficher ici.</p>
              </div>
            </div> --}}
            @endforelse
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Précédent</span></button>
          <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Suivant</span></button>
        </div>
      </div>
        <div class="col-lg-5">
          <div class="p-3 bg-white rounded-4 shadow h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <h3 class="h6 m-0">À la une</h3>
              <div class="btn-group" role="group" aria-label="Résumé">
                 {{-- Ces boutons sont toujours gérés par votre script.js --}}
                <button class="btn btn-outline-secondary btn-sm active" data-duration="5">5 min</button>
                <button class="btn btn-outline-secondary btn-sm" data-duration="10">10 min</button>
                <button class="btn btn-outline-secondary btn-sm" data-duration="15">15 min</button>
              </div>
            </div>
            {{-- Restauration de la liste dynamique --}}
            <div class="list-group list-group-flush" id="essentielList">
                @forelse($une as $article)
                <a href="{{ route('articles.show', $article->id) }}" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1 text-truncate">{{ $article->title }}</h6>
                        <small class="text-body-secondary">{{ \Carbon\Carbon::parse($article->date)->diffForHumans() }}</small>
                    </div>
                    <p class="mb-1 text-truncate-3">{{ $article->excerpt }}</p>
                </a>
                @empty
                <div class="text-center p-4">
                    <p class="text-secondary">Aucun article à la une pour le moment.</p>
                </div>
                @endforelse
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <section id="actus" class="py-4">
    <div class="container">
      {{-- Le composant Livewire s'occupe de tout --}}
      @livewire('derniers-articles')
    </div>
  </section>

  <section id="webradio" class="py-4 bg-white">
    <div class="container">
      <div class="row g-4 align-items-center">
        <div class="col-lg-6">
          <div class="p-3 rounded-4 border reveal">
            <div class="d-flex align-items-center gap-2 mb-2">
              <div class="feature-icon"><i class="bi bi-broadcast"></i></div>
              <h3 class="h6 m-0">Webradio — Direct</h3>
            </div>
            <audio id="radioPlayer" class="w-100" controls preload="none">
              <source src="https://securestreams.autopo.st:2584/;" type="audio/mpeg" />
              Votre navigateur ne supporte pas l'audio HTML5.
            </audio>
          </div>
        </div>
        <div class="col-lg-6" id="webtv">
          <div class="p-3 rounded-4 border reveal">
            <div class="d-flex align-items-center gap-2 mb-2">
              <div class="feature-icon" style="background:rgba(2,166,201,.12);color:var(--bleu)"><i class="bi bi-tv"></i></div>
              <h3 class="h6 m-0">WebTV — Dernière vidéo</h3>
            </div>

            <div class="ratio ratio-16x9 rounded-3 overflow-hidden">
              <iframe src="https://www.youtube.com/embed/vGF1cdsSxZI" title="WebTV" allowfullscreen loading="lazy"></iframe>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5">
    <div class="container">
      <div class="row g-3">
        <div class="col-md-4">
          <div class="p-4 bg-white rounded-4 shadow-sm h-100 reveal">
            <div class="feature-icon mb-2"><i class="bi bi-compass"></i></div>
            <h4 class="h6">Vision</h4>
            <p class="mb-0 text-secondary">Informer, inspirer et relier les citoyens par un journalisme rigoureux et accessible.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-4 bg-white rounded-4 shadow-sm h-100 reveal">
            <div class="feature-icon mb-2" style="background:rgba(2,166,201,.12);color:var(--bleu)"><i class="bi bi-bullseye"></i></div>
            <h4 class="h6">Mission</h4>
            <p class="mb-0 text-secondary">Donner la priorité aux sujets de gouvernance, société, environnement et économie avec des formats variés.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-4 bg-white rounded-4 shadow-sm h-100 reveal">
            <div class="feature-icon mb-2" style="background:rgba(255,204,51,.15);color:#9f7a00"><i class="bi bi-heart-pulse"></i></div>
            <h4 class="h6">Valeurs</h4>
            <p class="mb-0 text-secondary">Indépendance, transparence, pluralité des points de vue, lutte contre la désinformation.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-4 bg-white">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="h5 m-0">Album photos & vidéos</h3>
        <a class="btn btn-sm btn-outline-secondary" href="#">Tout voir</a>
      </div>
      <div class="row g-3 gallery" id="galleryWrap"></div>
    </div>
  </section>

  <section id="newsletter" class="py-5">
    <div class="container">
      <div class="row g-4 align-items-center">
        <div class="col-lg-7">
          <div class="p-4 p-lg-5 bg-white rounded-4 shadow-sm">
            <h3 class="h4">Recevez l'essentiel de Sioka</h3>
            <p class="text-secondary mb-4">Un récap quotidien des sujets citoyens et des programmes Webradio/WebTV.</p>
            <form class="row g-2" novalidate>
              <div class="col-12 col-md">
                <label for="nlEmail" class="visually-hidden">E‑mail</label>
                <input type="email" id="nlEmail" class="form-control form-control-lg" placeholder="vous@exemple.org" required>
                <div class="invalid-feedback">Veuillez renseigner un e‑mail valide.</div>
              </div>
              <div class="col-12 col-md-auto d-grid">
                <button class="btn btn-lg btn-primary" type="submit"><i class="bi bi-envelope-paper me-1"></i> S'abonner</button>
              </div>
            </form>
            <small class="text-muted d-block mt-2">En vous abonnant, vous acceptez notre politique de confidentialité.</small>
          </div>
        </div>
        <div class="col-lg-5">
          <img src="https://picsum.photos/800/520?random=88" alt="Newsletter" class="img-fluid rounded-4 shadow-sm">
        </div>
      </div>
    </div>
  </section>

  @include('composants.footer')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('/js/script.js') }}"></script>
  @livewireScripts
</body>
</html>