@fluxAppearance

<script>
    window.__fluxApplyAppearance = window.Flux.applyAppearance;

    window.reapplyFluxAppearance = function () {
        const appearance = (window.Flux && 'appearance' in window.Flux)
            ? window.Flux.appearance
            : (window.localStorage.getItem('flux.appearance') || 'system');

        window.__fluxApplyAppearance(appearance);
    };

    document.addEventListener('livewire:initialized', window.reapplyFluxAppearance);
    document.addEventListener('livewire:navigated', window.reapplyFluxAppearance);
</script>
