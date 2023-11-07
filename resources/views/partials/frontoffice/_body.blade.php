@include('partials.frontoffice._body_loader')

<main class="main-content" id="main-content">
    @include('partials.frontoffice._body_nav')

    {{ $slot }}

    @include('partials.frontoffice._body_client')

    @include('partials.frontoffice._body_footer')
    @include('partials.frontoffice._body_scrolltop')
</main>
@include('partials.frontoffice._scripts')
@include('partials.frontoffice._app_toast')
<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formTitle">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="main_form"></div>
            </div>
        </div>
    </div>
</div>
