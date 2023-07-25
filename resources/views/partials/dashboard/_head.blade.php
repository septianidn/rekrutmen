

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



<link rel="stylesheet" href="{{asset('vendor/aos/dist/aos.css')}}" />
<style>
    th.hide-search input{
       display: none;
    }
 </style>
 @include('sweetalert::alert')

 
<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/select2/css/select2-bootstrap-5-theme.rtl.min.css') }}" rel="stylesheet">

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
   
   
   </style>
