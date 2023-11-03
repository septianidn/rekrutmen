@extends('errors::layout')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message', __('Page Expired'))
@section('button')
@section('image')
    {{ asset(__('images/error/419.png')) }}
@endsection
<button class="btn btn-block" onclick="window.location.href='{{ route('landingpage') }}'">Kembali Ke
    Beranda</button>
@endsection
