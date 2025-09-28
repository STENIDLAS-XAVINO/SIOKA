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
    @livewireStyles
</head>
<body>
    @include('composants.header')

    <main class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <h1 class="mb-4">{{ $article->title }}</h1>
                    <p class="text-muted small">Publié le {{ \Carbon\Carbon::parse($article->date)->format('d/m/Y') }} par {{ $article->author }}</p>
                    
                    @if($article->image)
                    <figure class="figure mb-4">
                        <img src="{{ asset('storage/' . $article->image) }}" class="figure-img img-fluid rounded" alt="{{ $article->title }}">
                        <figcaption class="figure-caption">{{ $article->excerpt }}</figcaption>
                    </figure>
                    @endif

                    <div class="lead mb-4">{{ $article->excerpt }}</div>

                    <div class="article-content">
                        <p>{{ $article->content }}</p>
                        @if($article->url)
                            <p>
                                <a href="{{ $article->url }}" target="_blank" rel="noopener noreferrer">Lire l'article original</a>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('composants.footer')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('/js/script.js') }}"></script>
    @livewireScripts
</body>
</html>