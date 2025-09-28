  <div class="container-fluid d-flex align-items-center justify-content-between">
    <span>
      <img src="{{ asset('images/Logo_SIOKA_2.png') }}" alt="Logo" class="img-fluid" style="max-height: 40px;">        
    </span>
    <div class="d-flex align-items-center gap-3">
      <span class="d-none d-md-inline text-secondary-emphasis">Tableau de bord</span>
    </div>
    <div class="d-flex align-items-center gap-2">
      <button class="btn btn-sm btn-outline-secondary d-md-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNav" aria-label="Menu">
        <i class="bi bi-list"></i>
      </button>
      <button class="btn btn-sm theme-toggle" id="btnTheme"><i class="bi bi-moon-stars me-1"></i> Thème</button>
      <a class="btn btn-sm btn-outline-secondary d-none d-md-inline" href="{{ route('index') }}"><i class="bi bi-globe2 me-1"></i> Voir le site</a>
      {{-- <button class="btn btn-sm btn-primary" id="btnAdd"><i class="bi bi-plus-lg me-1"></i> Nouvel article</button> --}}
      <!-- NOM UTILISATEUR + DÉCONNEXION -->
      <div class="dropdown d-none d-md-inline">
        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
          Admin
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="dropdown-item text-danger" type="submit"><i class="bi bi-box-arrow-right me-1"></i> Déconnexion</button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </div>