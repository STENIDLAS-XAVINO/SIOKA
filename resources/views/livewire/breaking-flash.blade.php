<div>
<div id="breaking" class="breaking py-2" role="region" aria-live="polite">
    <div class="container d-flex gap-3 align-items-center">
        <span class="text-uppercase small fw-bold">
            <i class="bi bi-broadcast me-1"></i> Breaking
        </span>

        <div class="marquee flex-grow-1 small">
            @foreach($flashInfos as $flash)
                <span>{{ $flash->contenu }} • </span>
            @endforeach
        </div>

        <button class="btn btn-sm btn-light" id="btnCloseBreaking" aria-label="Masquer">
            <i class="bi bi-x"></i>
        </button>
    </div>
</div>

@push('scripts')
<script>
    // Fermer le flash
    document.getElementById('btnCloseBreaking')?.addEventListener('click', function(){
        document.getElementById('breaking').style.display = 'none';
        document.body.style.paddingTop = '0'; // Ajuste le padding du body
    });

    // Animation marquee infinie
    const marquee = document.querySelector('#breaking .marquee');
    if (marquee) {
        let span = marquee.querySelector('span');
        let speed = 1; // vitesse
        let left = marquee.offsetWidth;

        function animate() {
            left--;
            if(left < -span.offsetWidth) left = marquee.offsetWidth;
            span.style.transform = `translateX(${left}px)`;
            requestAnimationFrame(animate);
        }
        animate();
    }

</script>
@endpush

</div>
