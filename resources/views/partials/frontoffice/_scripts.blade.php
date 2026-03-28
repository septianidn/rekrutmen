<script src="{{ asset('js/frontoffice/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/frontoffice/main.js') }}"></script>
<script src="{{ asset('js/frontoffice/jquery-3.7.1.min.js') }}"></script>

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
