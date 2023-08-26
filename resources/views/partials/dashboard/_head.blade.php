

<!-- Favicon -->

<link rel="shortcut icon" href="{{ asset('images/backoffice/logo/logounand30.svg') }}" />
<link rel="stylesheet" href="{{asset('css/libs.min.css')}}">


<link rel="stylesheet" href="{{asset('css/hope-ui.css?v=1.1.0')}}">
<link rel="stylesheet" href="{{asset('css/custom.css?v=1.1.0')}}">
<link rel="stylesheet" href="{{asset('css/dark.css?v=1.1.0')}}">
<link rel="stylesheet" href="{{asset('css/rtl.css?v=1.1.0')}}">
<link rel="stylesheet" href="{{asset('css/customizer.css?v=1.1.0')}}">

<!-- Fullcalender CSS -->
<link rel="stylesheet" href="{{ asset('vendor/flatpickr/dist/flatpickr.min.css') }}">
<link rel='stylesheet' href="{{asset('vendor/fullcalendar/core/main.css')}}" />
<link rel='stylesheet' href="{{asset('vendor/fullcalendar/daygrid/main.css')}}" />
<link rel='stylesheet' href="{{asset('vendor/fullcalendar/timegrid/main.css')}}" />
<link rel='stylesheet' href="{{asset('vendor/fullcalendar/list/main.css')}}" />
<link rel="stylesheet" href="{{asset('vendor/Leaflet/leaflet.css')}}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-..." crossorigin="anonymous">


<!-- SURVEY JS CREATOR -->
{{-- <link href="https://unpkg.com/survey-jquery/defaultV2.min.css" type="text/css" rel="stylesheet">

<link rel="stylesheet" href="https://unpkg.com/survey-core@1.9.101/defaultV2.css" />
<link rel="stylesheet" href="https://unpkg.com/survey-creator-core@1.9.101/survey-creator-core.css" /> --}}




<link rel="stylesheet" href="{{asset('vendor/aos/dist/aos.css')}}" />
<style>
    th.hide-search input{
       display: none;
    }
 </style>
 @include('sweetalert::alert')

 
<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/select2/css/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet">

<link href="{{ asset('vendor/tagify/tagify.css') }}" rel="stylesheet">

{{-- Custom Css From library --}}

<style>
   .select2-container--bootstrap-5.select2-container--focus .select2-selection,.select2-container--bootstrap-5.select2-container--open .select2-selection
   {
      border-color:#009A4B;
      box-shadow:0 0 0 0; 
   }

   .select2-container--bootstrap-5 .select2-dropdown .select2-search .select2-search__field:focus{
      border-color:#009A4B;
      box-shadow:0 0 0 0; 
   }
   .select2-container--bootstrap-5 .select2-dropdown .select2-results__options .select2-results__option.select2-results__option--selected,.select2-container--bootstrap-5 .select2-dropdown .select2-results__options .select2-results__option[aria-selected=true]:not(.select2-results__option--highlighted){
      color:#000;
      background-color:#e9ecef
   }
   .select2-container--bootstrap-5 .select2-dropdown .select2-results__options .select2-results__option.select2-results__option--highlighted{
      color:#fff;
      background-color:#009A4B;
      }
   
   .card-soal {
    border-left: 5px solid transparent; /* Menggunakan border awal dengan warna transparan */
    transition: border-left 0.3s ease, transform 0.3s ease;  /* Waktu transisi dan jenis efek transisi (ease = efek pelan-pelan) */
   }

   .card-soal.active {
      border-left-color: #009A4B; 
      transform: scale(1.01);
   }
   .dropup .dropdown-menu {
    top: auto;
    bottom: 100%; 
}
   .drag-icon:hover{
      pointer-events: painted;
   }
   .border-green{
      border: 0;
      transition: #66C393 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
   }
   .border-green:focus{
      border-bottom:  0.3px solid #66C393;
      box-shadow: 0 0 0 rgba(102, 195, 147, 0.5);
   }
   .input-information{
    width: 100%;
    margin-top: .55rem;
    font-size: .875em;
    color: #000
   }
   .bg-grey{
      background-color: #F6F6F6
   }
   </style>
