<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/hope-ui.css?v=1.1.0') }}">
<link rel="stylesheet" href="{{ asset('css/custom.css?v=1.1.0') }}">
<link rel="stylesheet" href="{{ asset('css/dark.css?v=1.1.0') }}">
<link rel="stylesheet" href="{{ asset('css/rtl.css?v=1.1.0') }}">
<link rel="stylesheet" href="{{ asset('css/customizer.css?v=1.1.0') }}">
<link rel="stylesheet" href="{{ asset('css/frontoffice/main.css') }}">
<!-- ========================= CSS here ========================= -->

<link rel="stylesheet" href="{{ asset('css/frontoffice/animate.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontoffice/tiny-slider.css') }}">
<link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/frontoffice/glightbox.min.css') }}">

@include('sweetalert::alert')

<style>
    @media (max-width: 991.98px) {
        .content .bg {
            height: 500px;
        }
    }

    header {
        max-height: 0px;
    }

    .content .contents,
    .content .bg {
        width: 50%;
    }

    @media (max-width: 1199.98px) {

        .content .contents,
        .content .bg {
            width: 100%;
        }
    }

    .content .bg {
        background-size: cover;
        background-position: center;
    }

    .content a {
        color: #888;
        text-decoration: underline;
    }

    .text-14 {
        font-size: 12px;
    }

  
</style>
