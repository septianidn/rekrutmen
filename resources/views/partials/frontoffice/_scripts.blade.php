<script src="{{ asset('js/frontoffice/jquery-3.7.1.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="{{ asset('js/frontoffice/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/frontoffice/main.js') }}"></script>

<script src="{{ asset('js/plugins/form-wizard.js') }}"></script>

@if (in_array('vanilla-counter', $assets ?? []))
    <script defer="" src="{{ asset('js/frontoffice/vanilla-counter.js') }} "></script>
@endif



@if (in_array('wow', $assets ?? []))
    <script src="{{ asset('js/frontoffice/wow.min.js') }}"></script>
@endif

@if (in_array('glightbox', $assets ?? []))
    <script src="{{ asset('js/frontoffice/glightbox.min.js') }}"></script>
@endif
@if (in_array('slider', $assets ?? []))
    <script src="{{ asset('js/frontoffice/tiny-slider.js') }}"></script>
@endif

@if (in_array('animation', $assets ?? []))
    <script src="{{ asset('vendor/aos/dist/aos.js') }}"></script>
@endif
<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>

<script data-navigate-once>
    document.addEventListener('livewire:navigated', function() {

})
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(function(el) {
            el.removeAttribute('data-bs-toggle');
            var menu = el.parentElement.querySelector('.dropdown-menu');

            el.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                menu.classList.toggle('show');
            });
        });

        document.addEventListener('click', function(e) {
            document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
                if (!menu.parentElement.contains(e.target)) {
                    menu.classList.remove('show');
                }
            });
        });

        // Alert dismiss handler
        document.querySelectorAll('.btn-close[data-bs-dismiss="alert"]').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var alert = btn.closest('.alert');
                if (alert) {
                    alert.classList.remove('show');
                    alert.addEventListener('transitionend', function() {
                        alert.remove();
                    });
                    // Fallback if no transition
                    setTimeout(function() { if (alert.parentNode) alert.remove(); }, 300);
                }
            });
        });
    });
</script>
