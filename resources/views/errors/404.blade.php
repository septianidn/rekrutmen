@extends('errors::layout')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Oops, Halaman Tidak Ditemukan'))
@section('description', __('Halaman yang anda cari tidak ditemukan'))
@section('image')
    {{ asset(__('images/error/notfound.jpg')) }}
@endsection
@section('button')
<button class="btn btn-block"
onclick="window.location.href='{{ route('landingpage') }}'">Kembali Ke
Beranda</button>
@endsection