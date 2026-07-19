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
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>


@include('sweetalert::alert')

<style>
    @media (max-width: 991.98px) {
        .content .bg {
            height: 500px;
        }
    }

    header.header {
        position: relative;
        z-index: 100;
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

    /* Suppress the green underline pseudo-element on auth nav items */
    #nav .nav-auth-item > a::before,
    #nav .nav-auth-item:hover > a::before {
        display: none !important;
        width: 0 !important;
        opacity: 0 !important;
    }

    /* Both auth items: flex container so content is centred in the nav row height */
    #nav .nav-auth-item {
        display: flex !important;
        align-items: center;
    }

    /* Masuk — remove inherited vertical padding, flex keeps it centred via the li */
    #nav .nav-auth-item .nav-masuk {
        display: inline-flex !important;
        align-items: center;
        gap: 5px;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        color: #009a4b;
        font-weight: 500;
        font-size: 14px;
        margin-left: 20px;
    }
    #nav .nav-auth-item .nav-masuk i {
        font-size: 14px;
        display: inline !important;
    }
    #nav .nav-auth-item .nav-masuk:hover {
        color: #026d36 !important;
    }

    /* Daftar — compact button, same vertical centre as Masuk via the shared li rule */
    #nav .nav-auth-item .nav-daftar {
        background: #009a4b;
        color: #fff !important;
        border-radius: 4px;
        padding: 10px 24px !important;
        margin-left: 10px;
        font-size: 14px;
        font-weight: 500;
        line-height: 1.4 !important;
        height: auto !important;
    }
    #nav .nav-auth-item .nav-daftar:hover {
        background: #026d36;
        color: #fff !important;
    }

    /* Logged-in li — row layout, centred vertically */
    #nav .nav-auth-loggedin {
        display: flex !important;
        align-items: center;
        gap: 12px;
        padding-left: 20px;
    }
    #nav .nav-notif-trigger {
        color: #333;
        display: inline-flex;
        align-items: center;
        line-height: 1;
    }
    #nav .nav-notif-trigger i {
        font-size: 26px;
        line-height: 1;
    }
    /* Isolate dropdown items from the .navbar-nav .nav-item a theme rule
       (padding:30px 0 strips their horizontal padding and adds hover underlines) */
    #nav .nav-notif-wrap .dropdown-menu {
        overflow: hidden;
    }
    #nav .nav-notif-wrap .dropdown-item {
        padding-left: 16px;
        padding-right: 16px;
        text-transform: none;
    }
    #nav .nav-notif-wrap .dropdown-item::before,
    #nav .nav-notif-wrap .dropdown-item::after {
        display: none;
    }

    /* Mobile collapsed state */
    @media (max-width: 991px) {
        #nav .nav-auth-item {
            border-top: 1px solid #eee;
            margin-top: 4px;
            padding-top: 8px;
        }
        #nav .nav-auth-item .nav-masuk {
            margin-left: 0;
        }
        #nav .nav-auth-item .nav-daftar {
            margin-left: 0;
            padding-left: 0 !important;
            padding-right: 0 !important;
            background: none;
            color: #009a4b !important;
            border-radius: 0;
        }
        #nav .nav-auth-loggedin {
            padding-left: 0;
            flex-wrap: wrap;
        }
    }
</style>
