@extends('errors::layout')

@section('title', __('Payment Required'))
@section('code', '402')
@section('message', __('Payment Required'))
@section('button')
<button class="btn btn-block"
onclick="window.location.href='{{ route('landingpage') }}'">Kembali Ke
Beranda</button>
@endsection