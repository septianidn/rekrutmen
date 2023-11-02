@extends('errors::layout')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', __('Anda Tidak Diizinkan'))
@section('description', __('Anda tidak memiliki izin untuk mengakses sumber daya ini. Harap hubungi administrator jika
    Anda memerlukan akses'))
@section('image')
    {{ asset(__('images/error/401.jpg')) }}
@endsection
@section('button')
<button class="btn btn-block"
onclick="window.location.href='{{ route('landingpage') }}'">Kembali Ke
Beranda</button>
@endsection