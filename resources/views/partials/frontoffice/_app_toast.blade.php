<script type="text/javascript">
    var toastMixin = Swal.mixin({
        toast: true,
        icon: 'success',
        title: 'General Title',
        animation: false,
        position: 'top-right',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    {{-- Success Message --}}
    @if (Session::has('success'))
        toastMixin.fire({
            animation: true,
            title: '{{ Session::get('success') }}',
        });
    @endif
    {{-- Errors Message --}}
    @if (Session::has('error'))
        toastMixin.fire({
            icon: 'error',
            title: '{{ Session::get('error') }}',
        });
    @endif
    @if (Session::has('errors') || (isset($errors) && is_array($errors) && count($errors) > 0))
        @php
            $errorMessages = Session::has('errors') ? Session::get('errors')->all() : $errors->all();
            $combinedErrorMessage = implode('<br>', $errorMessages);
        @endphp

        @if (!empty($combinedErrorMessage))
            toastMixin.fire({
                icon: 'error',
                title: '{!! $combinedErrorMessage !!}',
                onBeforeOpen: (toast) => {
                    toast.querySelector('.swal2-title').style
                        .textAlign = 'left';
                }
            });
        @endif
    @endif
</script>
