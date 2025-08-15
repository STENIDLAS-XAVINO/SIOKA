<footer class="pt-5 pb-4 mt-3">
    <div class="container">
      <div class="row g-4">
        <div class="col-12 col-lg-4">
          <div class="d-flex gap-3 fs-5">
            <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
            <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
          </div>
        </div>
        <div class="col-6 col-lg-2">
          <h6>Rubriques</h6>
          <ul class="list-unstyled small">
            <li><a href="#actus">Actualités</a></li>
            <li><a href="#gouvernance">Gouvernance</a></li>
            <li><a href="#societe">Société</a></li>
            <li><a href="#environnement">Environnement</a></li>
            <li><a href="#economie">Économie</a></li>
          </ul>
        </div>
        <div class="col-6 col-lg-2">
          <h6>À propos</h6>
          <ul class="list-unstyled small">
            <li><a href="#">Vision & Mission</a></li>
            <li><a href="#">Charte</a></li>
            <li><a href="#">Accessibilité</a></li>
            <li><a href="#">Contact</a></li>
          </ul>
        </div>
        <div class="col-12 col-lg-4">
          <h6>Coordonnées</h6>
          <p class="small mb-1">Lot VB6, Rue Samuel RAHAMEFY, Antananarivo, Madagascar</p>
          <p class="small mb-1">Email : radiosioka@gmail.com</p>
          <p class="small">Téléphone : +261 38 42 562 87</p>
        </div>
      </div>
      <hr class="my-4" />
      <div class="d-flex flex-column flex-sm-row justify-content-between small">
        <div class="d-flex gap-3"> &copy; Copyright {{ date('Y') }} SIOKA, all rights reserved. <a href="#">Cookies</a><a href="#">Confidentialité</a></div>
      </div>
    </div>
  </footer>

  <!-- SEARCH MODAL -->
  <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-6" id="searchLabel">Recherche</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <input type="search" class="form-control" id="searchInput" placeholder="Tapez votre recherche...">
          <div class="list-group mt-3" id="searchResults"></div>
        </div>
      </div>
    </div>
  </div>

  

