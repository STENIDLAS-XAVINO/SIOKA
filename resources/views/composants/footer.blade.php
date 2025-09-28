<footer class="pt-5 pb-4 mt-3" role="contentinfo">
  <div class="container">
    <div class="row g-4">
      <div class="col-12 col-lg-4">
        <div class="d-flex gap-3 fs-5" aria-label="Réseaux sociaux">
          <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="bi bi-facebook" aria-hidden="true"></i></a>
          <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i class="bi bi-youtube" aria-hidden="true"></i></a>
          <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="bi bi-instagram" aria-hidden="true"></i></a>
        </div>
      </div>

      <div class="col-6 col-lg-2">
        <h6 class="mb-2">Rubriques</h6>
        <ul class="list-unstyled small mb-0">
          <li><a href="#actus">Actualités</a></li>
          <li><a href="#gouvernance">Gouvernance</a></li>
          <li><a href="#societe">Société</a></li>
          <li><a href="#environnement">Environnement</a></li>
          <li><a href="#economie">Économie</a></li>
        </ul>
      </div>

      <div class="col-6 col-lg-2">
        <h6 class="mb-2">À propos</h6>
        <ul class="list-unstyled small mb-0">
          <li><a href="#">Vision &amp; Mission</a></li>
          <li><a href="#">Charte</a></li>
          <li><a href="#">Accessibilité</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </div>

      <div class="col-12 col-lg-4">
        <h6 class="mb-2">Coordonnées</h6>
        <p class="small mb-1">Lot VB6, Rue Samuel RAHAMEFY, Antananarivo, Madagascar</p>
        <p class="small mb-1">Email : <a href="mailto:radiosioka@gmail.com">radiosioka@gmail.com</a></p>
        <p class="small">Téléphone : <a href="tel:+261384256287">+261 38 42 562 87</a></p>
      </div>
    </div>

    <hr class="my-4" />

    <div class="d-flex flex-column flex-sm-row justify-content-between small">
      <div class="d-flex gap-3 align-items-center">
        <span>&copy; {{ date('Y') }} SIOKA — Tous droits réservés.</span>
        <a href="#" class="ms-2">Cookies</a>
        <a href="#" class="ms-2">Confidentialité</a>
      </div>

      <div class="mt-2 mt-sm-0">
        <a href="#top" class="small">Haut de page</a>
      </div>
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
        <input type="search" class="form-control" id="searchInput" placeholder="Tapez votre recherche..." aria-label="Recherche">
        <div class="list-group mt-3" id="searchResults" role="listbox" aria-live="polite"></div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  var searchModal = document.getElementById('searchModal');
  if (searchModal) {
    searchModal.addEventListener('shown.bs.modal', function () {
      var input = document.getElementById('searchInput');
      if (input) input.focus();
    });
  }

  // Optionnel : gérer "Haut de page"
  var topLink = document.querySelector('a[href="#top"]');
  if (topLink) {
    topLink.addEventListener('click', function(e) {
      e.preventDefault();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }
});
</script>
@endpush
