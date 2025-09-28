<div>
    <div class="p-3 rounded-4 border reveal">
    <div class="d-flex align-items-center gap-2 mb-2">
        <div class="feature-icon" style="background:rgba(2,166,201,.12);color:var(--bleu)"><i class="bi bi-tv"></i></div>
        <h3 class="h6 m-0">WebTV — Dernière vidéo</h3>
    </div>
    
    @if ($video)
        <div class="ratio ratio-16x9 rounded-3 overflow-hidden">
            <iframe 
                src="https://www.youtube.com/embed/{{ $video->youtube_id }}" 
                title="{{ $video->title }}" 
                allowfullscreen 
                loading="lazy">
            </iframe>
        </div>
    @else
        <div class="ratio ratio-16x9 rounded-3 overflow-hidden d-flex align-items-center justify-content-center bg-light text-muted">
            <p class="m-0 text-center">Aucune vidéo publiée pour le moment.</p>
        </div>
    @endif
</div>
</div>