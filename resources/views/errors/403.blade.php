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
    @auth
        @php
            $user = auth()->user();
            $home = $user->hasRole('employer')
                ? route('employer.index')
                : ($user->hasRole('mahasiswa')
                    ? route('jobseeker.index')
                    : route('backoffice.dashboard'));
        @endphp
        <a href="{{ $home }}" class="btn btn-block">Ke Dashboard</a>
    @else
        <a href="{{ route('landingpage') }}" class="btn btn-block">Ke Beranda</a>
    @endauth
@endsection
