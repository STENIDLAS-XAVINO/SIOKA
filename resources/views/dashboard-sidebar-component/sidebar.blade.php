<aside class="col-md-2 d-none d-md-block sidebar p-3">
    <div class="menu-title">MENU</div>
    <nav class="nav flex-column gap-1 mt-2">
        <a class="nav-link @if(Request::is('dashboard')) active @endif" href="{{route('dashboard')}}"><i class="bi bi-speedometer2 me-2"></i> Tableau de bord</a>
        <a class="nav-link @if(Request::is('articles') || Request::is('articles/*')) active @endif" href="{{route('articles')}}"><i class="bi bi-newspaper me-2"></i> Articles</a>
        <a class="nav-link @if(Request::is('flash_infos')) active @endif" href="{{ route('flash_infos') }}"><i class="bi bi-tv me-2"></i> Flash Infos</a>
        <a class="nav-link @if(Request::is('utilisateurs')) active @endif" href="{{ route('utilisateurs') }}"><i class="bi bi-people me-2"></i> Utilisateurs</a>
        <a class="nav-link @if(Request::is('derniere_video')) active @endif" href="{{ route('derniere_video') }}"><i class="bi bi-youtube me-2"></i>Dernière Vidéo </a>
        <a class="nav-link @if(Request::is('commentaires')) active @endif" href="#"><i class="bi bi-chat-left-text-fill me-2"></i> Commentaires</a>
        <a class="nav-link @if(Request::is('mail')) active @endif" href="#"><i class="bi bi-envelope-fill me-2"></i> Mail</a>
        <a class="nav-link @if(Request::is('galerie')) active @endif" href="#"><i class="bi bi-images me-2"></i> Galerie</a>
        <a class="nav-link @if(Request::is('parametres')) active @endif" href="#"><i class="bi bi-gear me-2"></i> Paramètres</a>
    </nav>
</aside>