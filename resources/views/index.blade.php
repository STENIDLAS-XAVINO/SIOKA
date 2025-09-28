<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Accueil | SIOKA</title>
  <meta name="description" content="Maquette HTML/CSS/JS + Bootstrap inspirée de sioka.org, avec Webradio, WebTV, rubriques citoyennes et actualités." />

  <link rel="icon" href="{{ asset('images/Logo_SIOKA_2.png') }}" type="image/png">
  <link rel="shortcut icon" href="{{ asset('images/Logo_SIOKA_2.png') }}" type="image/png">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <!-- AOS CSS -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <!-- Ton CSS -->
  <link rel="stylesheet" href="{{ asset('/css/style.css') }}">

  <style>
    /* Effet hover moderne pour cartes */
    .card.reveal {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card.reveal:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 20px rgba(0,0,0,0.15);
    }
    .carousel-caption {
      transition: background 0.4s ease;
    }
    .carousel-caption:hover {
      background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);
    }
  </style>

  @livewireStyles
</head>
<body id="top">
  @include('composants.header')

  {{-- Hero / Slider (derniers articles publiés) --}}
  <header class="hero pt-4 pb-3">
    <div class="container">
      <div class="row g-4 align-items-stretch">

        <!-- Slider -->
        <div class="col-lg-7">
          <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-aos="fade-up">
            <div class="carousel-indicators">
              @forelse($actus as $article)
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $loop->index }}" @if($loop->first) class="active" aria-current="true" @endif aria-label="Slide {{ $loop->index + 1 }}"></button>
              @empty
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              @endforelse
            </div>
            <div class="carousel-inner">
              @forelse($actus as $article)
                <div class="carousel-item @if ($loop->first) active @endif">
                  <a href="{{ route('articles.show', $article->id) }}" class="stretched-link">
                    @if($article->image)
                      <img src="{{ asset('storage/' . $article->image) }}" class="d-block w-100 rounded-4" alt="{{ $article->title }}" style="object-fit: cover; height: 500px;">
                    @endif
                  </a>
                  <div class="carousel-caption d-none d-md-flex flex-column justify-content-end align-items-start p-3" 
                      style="background: linear-gradient(to top, rgba(0,0,0,0.4), transparent); border-radius: 0 0 1rem 1rem;">
                    <span class="badge rounded-pill text-bg-secondary mb-1">{{ ucfirst($article->cat) }}</span>
                    <h4 class="text-white fw-bold mb-0">{{ $article->title }}</h4>
                  </div>
                </div>
              @empty
                <div class="carousel-item active">
                  <img src="https://via.placeholder.com/1200x500.png?text=Pas+d'articles" class="d-block w-100 rounded-4" alt="Pas d'articles">
                  <div class="carousel-caption d-none d-md-block">
                    <h5>Aucun article disponible</h5>
                  </div>
                </div>
              @endforelse
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Suivant</span>
            </button>
          </div>
        </div>

<!-- À la une -->
<div class="col-lg-5">
  <div class="p-3 bg-white rounded-4 shadow h-100" data-aos="fade-left">
    <div class="d-flex align-items-center justify-content-between mb-2">
      <h3 class="h6 m-0">À la une</h3>
      <div class="btn-group" role="group" aria-label="Résumé">
        <button class="btn btn-outline-secondary btn-sm active" data-duration="5">5 min</button>
        <button class="btn btn-outline-secondary btn-sm" data-duration="10">10 min</button>
        <button class="btn btn-outline-secondary btn-sm" data-duration="15">15 min</button>
      </div>
    </div>
    <div class="list-group list-group-flush" id="essentielList">
      @forelse($une as $article)
        <a href="{{ route('articles.show', $article->id) }}" class="list-group-item list-group-item-action reveal" data-aos="fade-up" data-aos-delay="50">
          <div class="d-flex w-100 justify-content-between align-items-center">
            <h6 class="mb-1 text-truncate">{{ $article->title }}</h6>
            <small class="text-body-secondary time-ago" data-timestamp="{{ $article->updated_at->timestamp }}">
              <!-- JS remplira automatiquement -->
            </small>
          </div>
        </a>
      @empty
        <div class="text-center p-4" data-aos="fade-up">
          <p class="text-secondary">Aucun article à la une pour le moment.</p>
        </div>
      @endforelse
    </div>
  </div>
</div>

      </div>
    </div>
  </header>

  {{-- Sections dynamiques --}}
  <section id="actus" class="py-4">
    <div class="container" data-aos="fade-up">
      @livewire('derniers-articles')
    </div>
  </section>

  {{-- Webradio et WebTV --}}
  <section id="webradio" class="py-4 bg-white">
      <div class="container">
          <div class="row g-4 align-items-center">

              {{-- Colonne de la Webradio --}}
              <div class="col-lg-6" data-aos="fade-right">
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

              {{-- Colonne de la WebTV --}}
              <div class="col-lg-6" data-aos="fade-left">
                  @livewire('derniere-video-public')
              </div>

          </div>
      </div>
  </section>

  {{-- Focus citoyen --}}
  <section id="focus-citoyen" class="py-5 bg-light">
    <div class="container">
      <h2 class="h4 mb-4" data-aos="fade-up">Focus citoyen</h2>
      <div class="row g-4">
        {{-- 3 cartes statiques --}}
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="50">
          <div class="card reveal h-100">
            <img src="https://via.placeholder.com/400x250.png?text=Initiative+Locale" class="card-img-top" alt="Initiative Locale">
            <div class="card-body">
              <h5 class="card-title">Initiative Locale</h5>
              <p class="card-text text-truncate-3">Découvrez comment les communautés locales s'engagent pour le développement durable et la transparence.</p>
              <a href="#" class="btn btn-outline-primary btn-sm">Lire plus</a>
            </div>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="card reveal h-100">
            <img src="https://via.placeholder.com/400x250.png?text=Droit+&+Citoyenneté" class="card-img-top" alt="Droit & Citoyenneté">
            <div class="card-body">
              <h5 class="card-title">Droit & Citoyenneté</h5>
              <p class="card-text text-truncate-3">Actualités et ressources pour mieux comprendre les droits civiques et les responsabilités de chacun.</p>
              <a href="#" class="btn btn-outline-primary btn-sm">Lire plus</a>
            </div>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="150">
          <div class="card reveal h-100">
            <img src="https://via.placeholder.com/400x250.png?text=Environnement" class="card-img-top" alt="Environnement">
            <div class="card-body">
              <h5 class="card-title">Environnement</h5>
              <p class="card-text text-truncate-3">Initiatives pour protéger l'environnement, sensibilisation et actions citoyennes à Madagascar.</p>
              <a href="#" class="btn btn-outline-primary btn-sm">Lire plus</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Émissions thématiques --}}
  <section id="emissions" class="py-5 bg-light">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 fw-bold" data-aos="fade-up">Émissions thématiques</h2>
        <a href="#" class="text-decoration-none" data-aos="fade-up" data-aos-delay="50">Voir toutes <i class="bi bi-arrow-right"></i></a>
      </div>
      <div class="row g-4">
        @foreach ([
          ['title'=>'Politique & Gouvernance','img'=>'https://via.placeholder.com/400x200.png?text=Émission+Politique','text'=>'Analyse et débats sur les questions politiques et la gouvernance à Madagascar.'],
          ['title'=>'Économie & Entrepreneuriat','img'=>'https://via.placeholder.com/400x200.png?text=Émission+Économie','text'=>'Discussions sur l’économie malgache et les initiatives entrepreneuriales locales.'],
          ['title'=>'Culture & Société','img'=>'https://via.placeholder.com/400x200.png?text=Émission+Culture','text'=>'Exploration des cultures malgaches, traditions et initiatives sociales.']
        ] as $emission)
        <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index*50 }}">
          <div class="card h-100 shadow-sm border-0 reveal">
            <img src="{{ $emission['img'] }}" class="card-img-top" alt="{{ $emission['title'] }}">
            <div class="card-body">
              <h5 class="card-title">{{ $emission['title'] }}</h5>
              <p class="card-text text-truncate-3">{{ $emission['text'] }}</p>
              <a href="#" class="btn btn-sm btn-outline-primary">En savoir plus</a>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  @include('composants.footer')

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  @livewireScripts

  <!-- AOS JS -->
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({
      duration: 1000,
      easing: 'ease-in-out',
      once: true,
    });
  </script>

  <script src="{{ asset('js/script_a_la_une.js') }}"></script>

  <script src="{{ asset('/js/script.js') }}"></script>
  @stack('scripts')
</body>
</html>
