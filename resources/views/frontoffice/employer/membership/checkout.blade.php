@extends('frontoffice.employer.index')
@section('membership', 'active')
@section('page-title', 'Pembayaran Membership')
@section('page-subtitle', 'Selesaikan pembayaran melalui Midtrans.')
@section('content')

<div class="card">
    <div class="card-body text-center">
        <h4 class="card-title">{{ $pembayaran->membership->nama_membership ?? 'Membership' }}</h4>
        <h2 class="text-primary mb-3">Rp {{ number_format($pembayaran->amount, 0, ',', '.') }}</h2>
        <p class="text-muted">Order ID: {{ $pembayaran->midtrans_order_id }}</p>
        <button id="pay-button" class="btn btn-primary btn-lg">Bayar Sekarang</button>
        <a href="{{ route('employer.membership.index') }}" class="btn btn-link">Kembali</a>
        <p class="text-muted small mt-3">
            Setelah pembayaran selesai, status membership akan diaktifkan otomatis dalam beberapa saat.
        </p>
    </div>
</div>


<script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        snap.pay(@json($snapToken), {
            onSuccess: function () {
                window.location.href = @json(route('employer.membership.index'));
            },
            onPending: function () {
                window.location.href = @json(route('employer.membership.index'));
            },
            onError: function () {
                alert('Pembayaran gagal. Silakan coba lagi.');
                window.location.href = @json(route('employer.membership.index'));
            },
            onClose: function () {
                // user closed popup without paying — leave pending row alone
            }
        });
    });
</script>

@endsection
