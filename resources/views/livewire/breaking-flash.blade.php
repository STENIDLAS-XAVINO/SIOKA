<div>
<div>
    @if($flashInfos->isNotEmpty())
        <div id="breaking" class="breaking py-2" role="region" aria-live="polite">
            <div class="container d-flex align-items-center gap-3">
                
                <!-- Label fixe -->
                <div class="breaking-label flex-shrink-0">
                    <span class="text-uppercase small fw-bold">
                        <i class="bi bi-broadcast me-1"></i> Breaking
                    </span>
                </div>

                <!-- Marquee qui défile -->
                <div class="marquee flex-grow-1 small overflow-hidden"></div>

                <!-- Bouton fermer -->
                <button class="btn btn-sm btn-light" id="btnCloseBreaking" aria-label="Masquer">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        </div>

        @php
            // Préparer le JSON des flashs sans limite
            $flashJson = $flashInfos->map(fn($f) => $f->contenu)->toArray();
        @endphp

        @push('scripts')
        <script>
        window.startBreaking = function() {
            const container = document.querySelector('.marquee');
            const flashInfos = @json($flashJson);

            if (!container || flashInfos.length === 0) return;

            // Vider le container et créer le span
            container.innerHTML = '';
            const span = document.createElement('span');
            span.className = 'marquee-content d-inline-block';
            container.appendChild(span);

            let current = 0;

            function scrollFlash() {
                span.textContent = flashInfos[current];
                span.style.transition = 'none';
                span.style.transform = `translateX(${container.offsetWidth}px)`;

                requestAnimationFrame(() => {
                    const distance = container.offsetWidth + span.offsetWidth + 50;
                    const speed = 100; // px/s
                    const duration = distance / speed; // en secondes

                    span.style.transition = `transform ${duration}s linear`;
                    span.style.transform = `translateX(${-span.offsetWidth - 50}px)`;
                });

                span.addEventListener('transitionend', function handler() {
                    span.removeEventListener('transitionend', handler);
                    current = (current + 1) % flashInfos.length;
                    scrollFlash();
                }, { once: true });
            }

            scrollFlash();
        };

        document.addEventListener('DOMContentLoaded', () => {
            const breaking = document.getElementById('breaking');
            const btnClose = document.getElementById('btnCloseBreaking');
            const btnOpen = document.getElementById('btnBreaking');

            // Démarrer le défilement au chargement
            window.startBreaking();

            // Fermer le flash
            btnClose.addEventListener('click', () => {
                breaking.classList.add('d-none');
            });

            // Réouvrir le flash et relancer le défilement
            btnOpen.addEventListener('click', () => {
                breaking.classList.remove('d-none');
                window.startBreaking(); // relance le scroll proprement
            });
        });
        </script>
        @endpush
    @endif
</div>

</div>