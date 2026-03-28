@extends('errors::layout')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Akses Ditolak'))
@section('description',
    __(
    $exception->getMessage() ?:
    'Anda tidak memiliki izin untuk mengakses halaman ini. Harap
    logout dan login kembali terlebih dahulu',
    ))
@section('image')
    {{ asset(__('images/error/4032.png')) }}
@endsection
@section('button')
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-block" type="submit">
            {{ __('Log out') }}
        </button>
    </form>
@endsection
