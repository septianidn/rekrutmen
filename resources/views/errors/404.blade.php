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
onclick="window.location.href='@if(auth()->check() && auth()->user()->hasRole('employer')){{ route('employer.index') }}@elseif(auth()->check() && auth()->user()->hasRole('mahasiswa')){{ route('jobseeker.index') }}@else{{ route('landingpage') }}@endif'">Kembali Ke
Beranda</button>
@endsection