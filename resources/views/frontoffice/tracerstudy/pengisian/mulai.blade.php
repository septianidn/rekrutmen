<x-front-office-layout :assets="$assets ?? []">

    <section class="section">
        <div class="container">
            @if ($paket_soal)
                {!! $paket_soal->deskripsi !!}
            @endif
        </div>
    </section>


</x-front-office-layout>
