@extends('errors::layout')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('Terjadi Kesalahan Server'))
@section('description',
    __(
    $exception->getMessage() ?:
    'Terjadi masalah teknis pada server. Kami sedang berusaha
    memperbaikinya.',
    ))
@section('image')
    {{ asset(__('images/error/500.jpg')) }}
@endsection
@section('button')
<button class="btn btn-block"
onclick="window.location.href='{{ route('landingpage') }}'">Kembali Ke
Beranda</button>
@endsection