<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $article->title }} | SIOKA</title>
  <meta name="description" content="{{ $article->excerpt }}" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('/css/style.css') }}">

  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <!-- AOS CSS -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <style>
    /* Hover animations */
    .figure-img, .btn-outline-primary {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .figure-img:hover, .btn-outline-primary:hover {
      transform: translateY(-3px) scale(1.02);
      box-shadow: 0 12px 24px rgba(0,0,0,0.15);
    }
    .article-content p {
      margin-bottom: 1rem;
    }
  </style>

  @livewireStyles
</head>
<body>
@include('composants.header')

<main class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">

        {{-- Titre et info --}}
        <h1 class="mb-3 animate__animated animate__fadeInUp" data-aos="fade-up">{{ $article->title }}</h1>
        <p class="text-muted small mb-4 animate__animated animate__fadeInUp" data-aos="fade-up" data-aos-delay="100">
          Publié le {{ \Carbon\Carbon::parse($article->date)->format('d/m/Y') }} par {{ $article->author }}
        </p>

        {{-- Image principale --}}
        @if($article->image)
        <figure class="figure mb-4" data-aos="zoom-in">
          <img src="{{ asset('storage/' . $article->image) }}" class="figure-img img-fluid rounded" alt="{{ $article->title }}">
          <figcaption class="figure-caption">{{ $article->excerpt }}</figcaption>
        </figure>
        @endif

        {{-- Extrait --}}
        <div class="lead mb-4 animate__animated animate__fadeInUp" data-aos="fade-up" data-aos-delay="150">{{ $article->excerpt }}</div>

        {{-- Contenu --}}
        <div class="article-content animate__animated animate__fadeInUp" data-aos="fade-up" data-aos-delay="200">
          {!! nl2br(e($article->content)) !!}
          @if($article->url)
            <p class="mt-3">
              <a href="{{ $article->url }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-primary">Lire l'article original</a>
            </p>
          @endif
        </div>

        {{-- Émissions statiques en bas --}}
        <section id="emissions" class="py-5 mt-5 bg-light">
          <div class="container">
            <h2 class="h4 mb-4" data-aos="fade-up">Émissions thématiques</h2>
            <div class="row g-4">
              @php
                $emissions = [
                  ['title'=>'Politique & Gouvernance','img'=>'https://via.placeholder.com/400x200.png?text=Émission+Politique','desc'=>'Analyse et débats sur les questions politiques et la gouvernance à Madagascar.'],
                  ['title'=>'Économie & Entrepreneuriat','img'=>'https://via.placeholder.com/400x200.png?text=Émission+Économie','desc'=>'Discussions sur l’économie malgache et les initiatives entrepreneuriales locales.'],
                  ['title'=>'Culture & Société','img'=>'https://via.placeholder.com/400x200.png?text=Émission+Culture','desc'=>'Exploration des cultures malgaches, traditions et initiatives sociales.'],
                ];
              @endphp

              @foreach($emissions as $i => $em)
              <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0 reveal" data-aos="fade-up" data-aos-delay="{{ ($i+1)*100 }}">
                  <img src="{{ $em['img'] }}" class="card-img-top" alt="{{ $em['title'] }}">
                  <div class="card-body">
                    <h5 class="card-title">{{ $em['title'] }}</h5>
                    <p class="card-text text-truncate-3">{{ $em['desc'] }}</p>
                    <a href="#" class="btn btn-sm btn-outline-primary">En savoir plus</a>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </section>

      </div>
    </div>
  </div>
</main>

@include('composants.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@livewireScripts
<script src="{{ asset('/js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({ duration: 1000, easing: 'ease-in-out', once: true });
</script>
</body>
</html>
