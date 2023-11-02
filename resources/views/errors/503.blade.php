@extends('errors::layout')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __('Service Unavailable'))
@section('button')
<button class="btn btn-block"
onclick="window.location.href='{{ route('landingpage') }}'">Kembali Ke
Beranda</button>
@endsection