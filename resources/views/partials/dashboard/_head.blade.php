<!-- Favicon -->

<link rel="shortcut icon" href="{{ asset('images/backoffice/logo/logounand30.svg') }}" />
<link rel="stylesheet" href="{{ asset('css/libs.min.css') }}">


<link rel="stylesheet" href="{{ asset('css/hope-ui.css?v=1.1.0') }}">
<link rel="stylesheet" href="{{ asset('css/custom.css?v=1.1.0') }}">
<link rel="stylesheet" href="{{ asset('css/dark.css?v=1.1.0') }}">
<link rel="stylesheet" href="{{ asset('css/rtl.css?v=1.1.0') }}">
<link rel="stylesheet" href="{{ asset('css/customizer.css?v=1.1.0') }}">

<!-- Fullcalender CSS -->
<link rel="stylesheet" href="{{ asset('vendor/flatpickr/dist/flatpickr.min.css') }}">
<link rel='stylesheet' href="{{ asset('vendor/fullcalendar/core/main.css') }}" />
<link rel='stylesheet' href="{{ asset('vendor/fullcalendar/daygrid/main.css') }}" />
<link rel='stylesheet' href="{{ asset('vendor/fullcalendar/timegrid/main.css') }}" />
<link rel='stylesheet' href="{{ asset('vendor/fullcalendar/list/main.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/Leaflet/leaflet.css') }}" />
<link rel="stylesheet" href="{{ asset('css/hopepro/mail.min.css') }}" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
    integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />



<!-- SURVEY JS CREATOR -->
{{-- <link href="https://unpkg.com/survey-jquery/defaultV2.min.css" type="text/css" rel="stylesheet">

<link rel="stylesheet" href="https://unpkg.com/survey-core@1.9.101/defaultV2.css" />
<link rel="stylesheet" href="https://unpkg.com/survey-creator-core@1.9.101/survey-creator-core.css" /> --}}




<link rel="stylesheet" href="{{ asset('vendor/aos/dist/aos.css') }}" />
<style>
    th.hide-search input {
        display: none;
    }
</style>
@include('sweetalert::alert')


<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/select2/css/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet">

<link href="{{ asset('vendor/tagify/tagify.css') }}" rel="stylesheet">


{{-- <link href="{{ asset('vendor/filepond/dist/filepond.min.css') }}" rel="stylesheet"> --}}
{{-- 
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" /> --}}

{{-- <link href="https://unpkg.com/filepond@4.26.1/dist/filepond.min.css" rel="stylesheet"> --}}


{{-- Custom Css From library --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"
    rel="stylesheet" />
<style>
    /* SELECT2 CUSTOM CSS */
    .select2-container--bootstrap-5.select2-container--focus .select2-selection,
    .select2-container--bootstrap-5.select2-container--open .select2-selection {
        border-color: #009A4B;
        box-shadow: 0 0 0 0;
    }

    .select2-container--bootstrap-5 .select2-dropdown .select2-search .select2-search__field:focus {
        border-color: #009A4B;
        box-shadow: 0 0 0 0;
    }

    .select2-container--bootstrap-5 .select2-dropdown .select2-results__options .select2-results__option.select2-results__option--selected,
    .select2-container--bootstrap-5 .select2-dropdown .select2-results__options .select2-results__option[aria-selected=true]:not(.select2-results__option--highlighted) {
        color: #000;
        background-color: #e9ecef
    }

    .select2-container--bootstrap-5 .select2-dropdown .select2-results__options .select2-results__option.select2-results__option--highlighted {
        color: #fff;
        background-color: #009A4B;
    }

    /* FORM BUILDER CUSTOM CSS */
    .card-soal {
        border-left: 5px solid transparent;
        /* Menggunakan border awal dengan warna transparan */
        transition: border-left 0.3s ease, transform 0.3s ease;
        /* Waktu transisi dan jenis efek transisi (ease = efek pelan-pelan) */
    }

    .card-soal.active {
        border-left-color: #009A4B;
        transform: scale(1.01);
    }

    .card-soal.show {
        opacity: 1;
        transform: translateY(0);
    }

    .dropup .dropdown-menu {
        top: auto;
        bottom: 100%;
    }

    .drag-icon:hover {
        pointer-events: painted;
    }

    .border-green {
        border: 0;
        transition: #66C393 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .border-green:focus {
        border-bottom: 0.3px solid #66C393;
        box-shadow: 0 0 0 rgba(102, 195, 147, 0.5);
    }

    .input-information {
        width: 100%;
        margin-top: .55rem;
        font-size: .875em;
        color: #000
    }

    .bg-grey {
        background-color: #F6F6F6
    }

    .fieldset-wizard-container {
        display: flex;
        transition: transform 0.5s ease;
    }

    .fieldset-wizard {
        flex: 0 0 100%;
        transition: transform 0.5s ease;
    }

    .fieldset-wizard:first-child {
        padding-left: 0;
    }

    .padding-10 {
        padding-right: 10px;
    }

    .dynamic-input {
        box-sizing: border-box;
        background: transparent;
        border: 0px;
        padding: 0.4rem 0.1rem;
        border-radius: 4px;
        line-height: 1.5;
        -webkit-transition: 0.5s;
        transition: 0.5s;
        outline: none;
    }

    .dynamic-input:hover,
    .dynamic-input:focus {
        border: 0.3px solid #66C393;
        width: auto;
        padding: 0.375rem 0.75rem;
        outline: 0;
        border-radius: 4px;
        background: transparent;
        box-shadow: 0 0.125rem 0.5rem rgba(27, 192, 35, 0.3);

    }


    /*
    #form-wizard2 fieldset:not(:first-of-type) {
        display: none;
    }

    .fieldset-wizard {
        display: none;
    }

    .fieldset-wizard.active {
        display: block;
        animation: slide-in-right 1.5s ease-in-out forwards;

    }

    @keyframes slide-in-right {
        0% {
            opacity: 0;
            transform: translateX(100%);
        }

        70% {
            opacity: 1;
            transform: translateX(0);
        }

        100% {
            opacity: 1;
            transform: translateX(0);
        }
    } */

    .navigation-page.active {
        background-color: #009A4B;
        color: white;
    }


    /* TAB CUSTOM CSS */
    .tab-bottom-bordered {
        border-bottom: 4px solid rgba(var(--bs-primary-rgb), 0.1);
    }

    .tab-bottom-bordered .nav-tabs .nav-link {
        color: #8a92a6;
        position: relative;
    }

    .tab-bottom-bordered .nav-tabs .nav-link::after {
        content: "";
        position: absolute;
        width: 0%;
        height: 3px;
        -webkit-border-radius: 0.25rem;
        border-radius: 0.25rem;
        background: var(--bs-primary);
        bottom: -3px;
        left: 50%;
        top: unset;
        z-index: 1;
        -webkit-transition: all 400ms ease;
        -o-transition: all 400ms ease;
        transition: all 400ms ease;
    }

    .tab-bottom-bordered .nav-tabs .nav-link::before {
        content: "";
        position: absolute;
        width: 0%;
        height: 3px;
        -webkit-border-radius: 0.25rem;
        border-radius: 0.25rem;
        background: var(--bs-primary);
        bottom: -3px;
        right: 50%;
        top: unset;
        z-index: 1;
        -webkit-transition: all 400ms ease;
        -o-transition: all 400ms ease;
        transition: all 400ms ease;
    }

    .tab-bottom-bordered .nav-tabs .nav-link.active {
        background-color: unset;
        color: var(--bs-primary);
        -webkit-box-shadow: unset;
        box-shadow: unset;
    }

    .tab-bottom-bordered .nav-tabs .nav-link.active::before {
        width: 60%;
        right: 0;
        -webkit-transition: all 400ms ease;
        -o-transition: all 400ms ease;
        transition: all 400ms ease;
    }

    .tab-bottom-bordered .nav-tabs .nav-link.active::after {
        width: 60%;
        left: 0;
        -webkit-transition: all 400ms ease;
        -o-transition: all 400ms ease;
        transition: all 400ms ease;
    }

    .tab-bottom-bordered.iq-custom-tab-border .nav-tabs .nav-link:nth-child(1) {
        padding-left: unset;
    }

    .table-responsive .dataTables_wrapper .row .dt-buttons {
        text-align: right;
    }

    .float-end-datatables {
        float: end;
        text-align: right;
    }

    .row.no-gutters [class*='col']:not(:first-child) {
        margin: 0px;
        padding: 0px;
        padding-right: 15px;
    }

    .singlechoice-addition-text {
        visibility: hidden;

    }
</style>
