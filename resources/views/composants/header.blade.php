<header id="siteHeader">

  <!-- BREAKING (Livewire injecte le composant) -->
  @livewire('breaking-flash')

  <!-- TOPBAR -->
  <div class="topbar py-2 bg-white">
    <div class="container d-flex align-items-center justify-content-between">
      <div class="d-flex gap-3 align-items-center">
        <nav class="d-none d-md-flex gap-3 small align-items-center">
          <a class="link-dark" href="https://radio.sioka.org/" target="_blank"><i class="bi bi-broadcast me-1"></i> Webradio</a>
          <a class="link-dark" href="https://tv.sioka.org/" target="_blank"><i class="bi bi-tv me-1"></i> WebTV</a>
          <span class="text-muted">|</span>
          <a class="link-dark" href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
          <a class="link-dark" href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
          <a class="link-dark" href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
        </nav>
      </div>

      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-sm btn-live" id="btnLive"><span class="live-dot me-2"></span>Direct</button>
        <button class="btn btn-sm btn-outline-secondary" id="btnBreaking" aria-controls="breaking" aria-expanded="true">
          <i class="bi bi-lightning-charge-fill me-1"></i> Breaking
        </button>
        <button class="btn btn-sm btn-outline-secondary d-md-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNav" aria-label="Menu"><i class="bi bi-list"></i></button>
      </div>
    </div>
  </div>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg bg-white">
    <div class="container">
      <a class="navbar-brand" href="/">
        <img src="{{ asset('/images/logo_SIOKA.png') }}" alt="Sioka Media" height="100" class="d-inline-block align-text-top">
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="Basculer la navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navMain">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link active" href="/">Accueil</a></li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="{{ route('gouvernance') }}" id="actualitesDropdown" role="button" aria-expanded="false">Gouvernance</a>
            <ul class="dropdown-menu" aria-labelledby="actualitesDropdown">
              <li><a class="dropdown-item" href="#transparence">Transparence</a></li>
              <li><a class="dropdown-item" href="#politique">Politique</a></li>
              <li><a class="dropdown-item" href="#foncier">Foncier</a></li>
            </ul>
          </li>

          <li class="nav-item"><a class="nav-link" href="{{ route('economie') }}">Économie</a></li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="{{ route('social') }}" id="socialDropdown" role="button" aria-expanded="false">Social</a>
            <ul class="dropdown-menu" aria-labelledby="socialDropdown">
              <li><a class="dropdown-item" href="#sante">Santé</a></li>
              <li><a class="dropdown-item" href="#education">Éducation</a></li>
              <li><a class="dropdown-item" href="#genre_droit_homme">Genre - Droit de l'Homme</a></li>
            </ul>
          </li>

          <li class="nav-item"><a class="nav-link" href="{{ route('sport-culture') }}">Sport & Culture</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('jeunes-femmes') }}">Jeunes & Femmes</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('equipe') }}">L'Équipe</a></li>
        </ul>

        <div class="d-flex gap-2 align-items-center">
          <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="bi bi-search"></i> Recherche</button>
          <button class="btn btn-outline-dark btn-sm" id="toggleDark"><i class="bi bi-moon"></i></button>
          <a href="{{ route('dashboard') }}" class="btn btn-danger btn-sm d-inline-flex align-items-center" style="text-decoration:none;">
            <span class="ms-1">Login</span>
            <i class="bi bi-box-arrow-in-right"></i>
          </a>
        </div>
      </div>
    </div>
  </nav>

</header>

<!-- Offcanvas Mobile Nav -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNav">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Menu</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fermer"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="list-unstyled mb-0">
      <li><a class="d-block py-2" href="/">Accueil</a></li>
      <li><a class="d-block py-2" href="#actus">Actualités</a></li>
      <li><a class="d-block py-2" href="#gouvernance">Gouvernance</a></li>
      <li><a class="d-block py-2" href="#societe">Société</a></li>
      <li><a class="d-block py-2" href="#environnement">Environnement</a></li>
      <li><a class="d-block py-2" href="#economie">Économie</a></li>
      <li><a class="d-block py-2" href="#culture">Culture</a></li>
      <li><a class="d-block py-2" href="#sport">Sport</a></li>
      <li><a class="d-block py-2" href="#webradio">Webradio</a></li>
      <li><a class="d-block py-2" href="#webtv">WebTV</a></li>
    </ul>
  </div>
</div>
